<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Accordiancontroller extends Controller
{
    public function getProvincesWithDistributors()
    {
        $provinces = Province::whereHas('regencies.distributors', function ($q) {
            $q->whereHas('user', function ($u) {
                $u->where('status', 1);
            });
        })
            ->select('id', 'name')
            ->get();

        return response()->json($provinces);
    }

    public function getRegenciesByProvinceWithDistributors(Request $request)
    {
        $provinceId = $request->input('province_id');

        $regencies = Regency::where('province_id', $provinceId)
            ->whereHas('distributors.user', function ($query) {
                $query->where('status', 1);
            })->select('id', 'name')->get();

        return response()->json($regencies);
    }



    public function showDistributors()
    {
        $distributorsByRegion = Cache::remember('distributors_by_region_view', now()->addMinutes(1), function () {
            return Province::select('id', 'name')
                ->with([
                    'regencies' => function ($q) {
                        $q->select('id', 'province_id', 'name')
                            ->with([
                                'distributors' => function ($q2) {
                                    $q2->select('id', 'regency_id')
                                        ->with(['shipments:id,name', 'district:id,name']);
                                }
                            ]);
                    }
                ])->get()
                ->mapWithKeys(function ($province) {
                    return [
                        $province->name => $province->regencies->mapWithKeys(function ($regency) {
                            if ($regency->distributors->isEmpty())
                                return [];
                            return [
                                $regency->name => $regency->distributors,
                            ];
                        })
                    ];
                });
        });

        return view('accordian', ['distributorsByRegion' => $distributorsByRegion]);
    }

    public function listDistributorsByRegencyId(Request $request)
    {
        $regencyId = $request->query('regency_id');

        if (!$regencyId) {
            return response()->json(['error' => 'regency_id is required'], 400);
        }

        $distributors = Distributor::where('regency_id', $regencyId)
            ->select('distributors.id', 'province_id', 'regency_id', 'district_id', 'full_name', 'address', 'primary_phone', 'google_maps_url', 'is_cod')
            ->join('users', 'distributors.user_id', '=', 'users.id')
            ->where('users.status', 1)
            ->with([
                'shipments',
                'district:id,name',
                'regency:id,name,province_id',
                'regency.province:id,name',
                'marketplaces' => function ($q) {
                    $q->select('name', 'icon')->withPivot('url');
                }
            ])
            ->get();
            

        return response()->json([
            'regency_id' => $regencyId,
            'distributors' => $distributors
        ]);
    }

    public function listDistributorsByRegionAndProvince(Request $request)
    {
        $regionName = $request->query('region_name');
        $provinceName = $request->query('province_name');

        if (!$regionName || !$provinceName) {
            return response()->json(['error' => 'Both region_name and province_name are required'], 400);
        }

        $distributors = Distributor::whereHas('regency', function ($query) use ($regionName, $provinceName) {
                $query->where('name', 'like', '%' . $regionName . '%')
                    ->whereHas('province', function ($query) use ($provinceName) {
                        $query->where('name', 'like', '%' . $provinceName . '%');
                    });
            })
            ->select('distributors.*')
            ->join('users', 'distributors.user_id', '=', 'users.id')
            ->where('users.status', 1)
            ->with([
                'shipments:id,name',
                'district:id,name',
                'regency:id,name,province_id',
                'regency.province:id,name',
                'marketplaces' => function ($q) {
                    $q->select('name', 'icon')->withPivot('url');
                }
            ])
            ->get();

        return response()->json([
            'region_name' => $regionName,
            'province_name' => $provinceName,
            'distributors' => $distributors
        ]);
    }


    public function searchRegions(Request $request)
    {
        $keyword = $request->input('keyword');

        $results = Distributor::select('distributors.id', 'regency_id', 'district_id')
            ->join('users', 'distributors.user_id', '=', 'users.id')
            ->where('users.status', 1)
            ->with(['regency:id,province_id,name', 'regency.province:id,name', 'district:id,name'])
            ->whereHas('regency', fn($q) => $q->where('name', 'like', "%$keyword%"))
            ->orWhereHas('district', fn($q) => $q->where('name', 'like', "%$keyword%"))
            ->get()
            ->groupBy(fn($d) => ($d->regency->province->name ?? '') . ' > ' . ($d->regency->name ?? ''));

        $final = $results->map(function ($group, $key) {
            return [
                'id' => md5($key),
                'label' => $key,
            ];
        })->values();

        return response()->json(['regions' => $final]);
    }

    public function getDistributorsByRegion(Request $request)
    {
        $regionLabel = $request->input('region');

        if (!str_contains($regionLabel, ' > ')) {
            return response()->json(['distributors' => []]);
        }

        [$province, $regency] = explode(' > ', $regionLabel);

        $distributors = Distributor::select('distributors.id', 'province_id', 'regency_id', 'district_id', 'village', 'full_name', 'address', 'primary_phone', 'photo_url', 'maps_url', 'is_cod', 'users.status')
            ->with([
                'regency:id,name,province_id',
                'regency.province:id,name',
                'district:id,name',
                'shipments:id,name',
                'marketPlaceDistributor',
            ])
            ->join('users', 'distributors.user_id', '=', 'users.id')
            ->where('users.status', 1)
            ->whereHas('regency', fn($q) => $q->where('name', $regency))
            ->get()
            ->map(function ($d) {
                return [
                    'name' => $d->full_name,
                    'address' => $d->address,
                    'phone' => $d->primary_phone,
                    'province' => $d->regency->province->name ?? '',
                    'regency' => $d->regency->name ?? '',
                    'district' => $d->district->name ?? '',
                    'village' => $d->village,
                    'photo_url' => $d->photo_url ?? 'https://mganik-assets.pages.dev/assets/placeholder_foto.png',
                    'maps_url' => $d->maps_url ?? '#',
                    'shipments' => $d->shipments->pluck('name')->toArray(),
                    'cod' => $d->is_cod,
                    'marketplaces' => $d->marketPlaceDistributor,
                ];
            });

        return response()->json(['distributors' => $distributors]);
    }
}

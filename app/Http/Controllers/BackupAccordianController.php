<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BackupAccordianController extends Controller
{
    public function getProvinces()
    {
        return Province::select('id', 'name')->get();
    }

    public function getDistributorsByProvince($id)
    {
        $province = Province::with([
            'regencies.distributors' => function ($q) {
                $q->select('id', 'regency_id', 'full_name', 'address', 'primary_phone', 'google_maps_url', 'is_cod')
                    ->with(['shipments:id,name', 'district:id,name']);
            }
        ])
        ->findOrFail($id);

        $grouped = $province->regencies->mapWithKeys(function ($regency) {
            if ($regency->distributors->isEmpty()) return [];
            return [$regency->name => $regency->distributors];
        });

        return response()->json($grouped);
    }


    public function showDistributors()
    {
        $distributorsByRegion = Cache::remember('distributors_by_region_view', now()->addMinutes(1), function () {
            return Province::select('id', 'name')
                ->with(['regencies' => function ($q) {
                    $q->select('id', 'province_id', 'name')
                        ->with(['distributors' => function ($q2) {
                            $q2->select('id', 'regency_id')
                                ->with(['shipments:id,name', 'district:id,name']);
                        }]);
                }])->get()
                ->mapWithKeys(function ($province) {
                    return [
                        $province->name => $province->regencies->mapWithKeys(function ($regency) {
                            if ($regency->distributors->isEmpty()) return [];
                            return [
                                $regency->name => $regency->distributors,
                            ];
                        })
                    ];
                });
        });

        return view('accordian', ['distributorsByRegion' => $distributorsByRegion]);
    }

    public function listDistributors()
    {
        $data = Cache::remember('distributors_by_region_json', now()->addMinutes(1), function () {
            return Province::select('id', 'name')
                ->with(['regencies' => function ($q) {
                    $q->select('id', 'province_id', 'name')
                        ->with(['distributors' => function ($q2) {
                            $q2->select('id', 'province_id', 'regency_id', 'district_id', 'full_name', 'address', 'primary_phone', 'google_maps_url', 'is_cod')
                                ->with([
                                    'shipments:id,name',
                                    'district:id,name',
                                    'regency:id,name,province_id',
                                    'regency.province:id,name',
                                    'marketplaces' => function ($q3) {
                                        $q3->select('marketplaces.id', 'name', 'icon')->withPivot('url');
                                    }
                                ]);
                        }]);
                }])->get()
                ->mapWithKeys(function ($province) {
                    return [
                        $province->name => $province->regencies->mapWithKeys(function ($regency) {
                            if ($regency->distributors->isEmpty()) return [];
                            return [
                                $regency->name => $regency->distributors->map(function ($d) {
                                    return [
                                        'full_name' => $d->full_name,
                                        'address' => $d->address,
                                        'district' => $d->district->name ?? '',
                                        'regency' => $d->regency->name ?? '',
                                        'province' => $d->regency->province->name ?? '',
                                        'primary_phone' => $d->primary_phone,
                                        'google_maps_url' => $d->google_maps_url,
                                        'is_cod' => $d->is_cod,
                                        'shipments' => $d->shipments->pluck('name')->toArray(),
                                        'marketplaces' => $d->marketplaces->map(function ($m) {
                                            return [
                                                'name' => $m->name,
                                                'icon' => $m->icon,
                                                'pivot' => ['url' => $m->pivot->url],
                                            ];
                                        }),
                                    ];
                                })
                            ];
                        })
                    ];
                });
        });

        return response()->json($data);
    }

    public function searchRegions(Request $request)
    {
        $keyword = $request->input('keyword');

        $results = Distributor::select('id', 'regency_id', 'district_id')
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

        $distributors = Distributor::select('id', 'province_id', 'regency_id', 'district_id', 'village', 'full_name', 'address', 'primary_phone', 'photo_url', 'maps_url', 'is_cod')
            ->with([
                'regency:id,name,province_id',
                'regency.province:id,name',
                'district:id,name',
                'shipments:id,name',
                'marketplaces' => function ($q) {
                    $q->select('marketplaces.id', 'name', 'icon')->withPivot('url');
                }
            ])
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
                    'marketplaces' => $d->marketplaces->map(function ($m) {
                        return [
                            'name' => $m->name,
                            'icon' => asset('storage/icons/' . $m->icon),
                            'pivot' => ['url' => $m->pivot->url],
                        ];
                    }),
                ];
            });

        return response()->json(['distributors' => $distributors]);
    }
}

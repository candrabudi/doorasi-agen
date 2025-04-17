<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Province;
use Illuminate\Http\Request;

class Accordiancontroller extends Controller
{
    public function showDistributors()
    {
        $provinces = Province::with(['regencies.distributors.shipments', 'regencies.distributors.district'])->get();
    
        $distributorsByRegion = [];
    
        foreach ($provinces as $province) {
            $provinceName = $province->name;
    
            foreach ($province->regencies as $regency) {
                $regencyName = $regency->name;
                $distributors = $regency->distributors;
                if ($distributors->isNotEmpty()) {
                    if (!isset($distributorsByRegion[$provinceName])) {
                        $distributorsByRegion[$provinceName] = [];
                    }
    
                    $distributorsByRegion[$provinceName][$regencyName] = $distributors;
                }
            }
        }
    
        return view('accordian', compact('distributorsByRegion'));
    }

    public function listDistributors()
    {
        // Fetch provinces with related regencies, distributors, and other nested data
        $provinces = Province::with([
            'regencies.distributors.shipments', 
            'regencies.distributors.district'
        ])->get();

        // Prepare the data structure to send back as JSON
        $distributorsByRegion = [];

        foreach ($provinces as $province) {
            $provinceName = $province->name;

            foreach ($province->regencies as $regency) {
                $regencyName = $regency->name;
                $distributors = $regency->distributors;
                
                if ($distributors->isNotEmpty()) {
                    if (!isset($distributorsByRegion[$provinceName])) {
                        $distributorsByRegion[$provinceName] = [];
                    }

                    $distributorsByRegion[$provinceName][$regencyName] = $distributors->map(function($distributor) {
                        return [
                            'full_name' => $distributor->full_name,
                            'address' => $distributor->address,
                            'district' => $distributor->district->name,
                            'regency' => $distributor->regency->name,
                            'province' => $distributor->province->name,
                            'primary_phone' => $distributor->primary_phone,
                            'google_maps_url' => $distributor->google_maps_url,
                            'is_cod' => $distributor->is_cod,
                            'shipments' => $distributor->shipments->pluck('name')->toArray(),
                            'marketplaces' => $distributor->marketplaces->map(function($marketplace) {
                                return [
                                    'name' => $marketplace->name,
                                    'url' => $marketplace->url,
                                    'icon' => $marketplace->icon
                                ];
                            })->toArray(),
                        ];
                    });
                }
            }
        }

        // Return the data as JSON
        return response()->json($distributorsByRegion);
    }

    

    public function searchRegions(Request $request)
    {
        $keyword = $request->input('keyword');

        $results = Distributor::with(['regency.province', 'district'])
            ->whereHas('regency', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('district', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->get()
            ->groupBy(function ($distributor) {
                $province = $distributor->regency->province->name ?? '';
                $regency = $distributor->regency->name ?? '';
                return "$province > $regency";
            });

        $final = [];
        foreach ($results as $group => $distributors) {
            $final[] = [
                'id' => md5($group),
                'label' => $group,
            ];
        }

        return response()->json(['regions' => $final]); 
    }

    public function getDistributorsByRegion(Request $request)
    {
        $regionLabel = $request->input('region'); 
        [$province, $regency] = explode(' > ', $regionLabel);

        $distributors = Distributor::with(['regency.province', 'district', 'shipments'])
            ->whereHas('regency', function ($query) use ($regency) {
                $query->where('name', $regency);
            })
            ->get()
            ->map(function ($distributor) {
                return [
                    'name' => $distributor->full_name,
                    'address' => $distributor->address,
                    'phone' => $distributor->primary_phone,
                    'province' => $distributor->province,
                    'regency' => $distributor->regency,
                    'district' => $distributor->district,
                    'village' => $distributor->village,
                    'photo_url' => $distributor->photo_url ?? 'https://mganik-assets.pages.dev/assets/placeholder_foto.png',
                    'maps_url' => $distributor->maps_url ?? '#',
                    'shipments' => $distributor->shipments->pluck('name')->toArray(),
                    'cod' => $distributor->is_cod,
                    'marketplaces' => $distributor->marketPlaces->map(function ($mp) {
                        return [
                            'name' => $mp->name,
                            'icon' => asset('storage/icons/'.$mp->icon),
                            'pivot' => [
                                'url' => $mp->pivot->url,
                            ],
                        ];
                    }),
                ];
            });

        return response()->json(['distributors' => $distributors]);
    }
}

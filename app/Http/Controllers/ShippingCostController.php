<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ShippingCostController extends Controller
{
    public function index()
    {
        return view('shipping_cost');
    }

    public function calculateShippingCost(Request $request)
    {
        $province = Province::where('name', strtoupper($request->province))->first();
        $regency = Regency::where('name', strtoupper('KABUPATEN '.$request->city))
            ->where('province_id', $province->id)
            ->first();  

        $district = District::where('regency_id', $regency->id)
            ->where('name', strtoupper($request->district))
            ->first();

        $distributors = DB::table('distributors')
            ->join('districts', 'distributors.district_id', '=', 'districts.id')
            ->join('regencies', 'districts.regency_id', '=', 'regencies.id')
            ->join('provinces', 'regencies.province_id', '=', 'provinces.id')
            ->select(
                'distributors.*',
                DB::raw("ROUND((
                    6371 * acos(
                        cos(radians($district->latitude)) *
                        cos(radians(districts.latitude)) *
                        cos(radians(districts.longitude) - radians($district->longitude)) +
                        sin(radians($district->latitude)) *
                        sin(radians(districts.latitude))
                    )
                ), 2) AS distance_km"),
                'districts.name as district_name',
                'regencies.name as regency_name',
                'provinces.name as province_name'
            )
            ->whereNotNull('districts.latitude')
            ->whereNotNull('districts.longitude')
            ->orderBy('distance_km')
            ->limit(4)
            ->get();
        
        $allLocationDistributors = [];
        foreach ($distributors as $distributor) {
            $locationData = $this->fetchLocationData($distributor->district_name, $distributor->regency_name, $distributor->province_name);

            if(!$locationData) {
                continue;
            }
            $locationData['full_name'] = $distributor->full_name;
            $locationData['address'] = $distributor->address;
            $locationData['primary_phone'] = $distributor->primary_phone;
            $locationData['province_name'] = $distributor->province_name;
            $locationData['regency_name'] = $distributor->regency_name;
            $locationData['district_name'] = $distributor->district_name;
            $locationData['distance_km'] = $distributor->distance_km;
            array_push($allLocationDistributors, $locationData);
        }

        $shippingRates = [];

        foreach ($allLocationDistributors as $locationDistributor) {
            $shippingRate = $this->getShippingRate(
                $locationDistributor['sub_district_id'],
                $request->sub_district_id,
                $request->weight
            );

            foreach ($shippingRate as $rate) {
                $data = [
                    'distributor_name' => $locationDistributor['full_name'],
                    'address' => $locationDistributor['address'],
                    'primary_phone' => $locationDistributor['primary_phone'],
                    'province_name' => $locationDistributor['province_name'],
                    'regency_name' => $locationDistributor['regency_name'],
                    'distance_km' => $locationDistributor['distance_km'],
                    'district_name' => $locationDistributor['district_name'],
                    'logistic_name' => $rate['logistic_name'],
                    'logistic_logo_url' => $rate['logistic_logo_url'],
                    'rate_code' => $rate['rate_code'],
                    'rate_name' => $rate['rate_name'],
                    'duration_type' => $rate['duration_type'],
                    'duration' => $rate['duration'],
                    'shipment_price' => $rate['shipment_price'],
                ];

                $shippingRates[] = $data;
            }
        }

        usort($shippingRates, function ($a, $b) {
            return $a['shipment_price'] <=> $b['shipment_price'];
        });

        return response()->json($shippingRates);

    }


    private function fetchLocationData($districtName, $regencyName, $provinceName)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json, text/plain, */*',
            'Use-Api-Key' => 'true',
        ])->get("https://popaket.com/service/logistic/v2/public/location", [
            'name' => $districtName.', '. $regencyName .', '. $provinceName
        ]);
    
        if (!$response->successful()) {
            return null;
        }
    
        $locations = $response->json()['data']['locations'] ?? [];
        $normalize = fn($str) => strtolower(trim($str));
    
        $targetDistrict = $normalize($districtName);
        $targetRegency = $normalize($regencyName);
        $targetProvince = $normalize($provinceName);
    
        foreach ($locations as $location) {
            $locDistrict = $normalize($location['district'] ?? '');
            $locCity = $normalize($location['city'] ?? '');
            $locProvince = $normalize($location['province'] ?? '');
    
            if (
                $locDistrict === $targetDistrict ||
                $locCity === $targetRegency ||
                $locProvince === $targetProvince
            ) {
                return $location;
            }
        }
    
        return null;
    }
    
    


    private function getShippingRate($originSubDistrict, $destinationSubDistrict, $weight)
    {
        $url = 'https://popaket.com/service/logistic/v3/public/rate';
    
        $response = Http::withHeaders([
            'Use-Api-Key' => 'true',
        ])->get($url, [
            'origin_sub_district' => $originSubDistrict,
            'destination_sub_district' => $destinationSubDistrict,
            'weight' => $weight,
            'include_flat_rate' => 'true',
        ]);
    
        if ($response->successful()) {
            $rates = $response->json()['data'];

            $allowedLogistics = ['JNE', 'ID Express', 'SAP Logistic', 'J&T Express', 'SiCepat'];
    
            $regularRates = array_filter($rates, function ($rate) use ($allowedLogistics) {
                return $rate['rate_type_name'] === 'Reguler' &&
                       in_array($rate['logistic_name'], $allowedLogistics);
            });
    
            if (!empty($regularRates)) {
                $filteredRates = array_map(function ($rate) {
                    return [
                        'logistic_name' => $rate['logistic_name'],
                        'logistic_logo_url' => $rate['logistic_logo_url'],
                        'rate_code' => $rate['rate_code'],
                        'rate_name' => $rate['rate_name'],
                        'duration_type' => $rate['duration_type'],
                        'duration' => $rate['duration'],
                        'shipment_price' => $rate['shipment_price'],
                    ];
                }, $regularRates);
    
                usort($filteredRates, function ($a, $b) {
                    return $a['shipment_price'] <=> $b['shipment_price'];
                });
    
                return $filteredRates;
            }
    
            return response()->json(['error' => 'No regular rates found'], 404);
        }
    
        return response()->json(['error' => 'Unable to fetch shipping rate'], $response->status());
    }
    
}

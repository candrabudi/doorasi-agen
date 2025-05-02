<?php

namespace App\Http\Controllers;

use App\Models\District;
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
        $district = District::where('name', strtoupper($request->district))->first();

        $distributors = DB::table('distributors')
            ->join('districts', 'distributors.district_id', '=', 'districts.id')
            ->select(
                'distributors.*',
                DB::raw("(
                    6371 * acos(
                        cos(radians($district->latitude)) *
                        cos(radians(districts.latitude)) *
                        cos(radians(districts.longitude) - radians($district->longitude)) +
                        sin(radians($district->latitude)) *
                        sin(radians(districts.latitude))
                    )
                ) AS distance_km"),
                'districts.name as district_name'
            )
            ->whereNotNull('districts.latitude')
            ->whereNotNull('districts.longitude')
            ->orderBy('distance_km')
            ->limit(3)
            ->get();

        $allLocationDistributors = [];
        foreach ($distributors as $distributor) {
            $locationData = $this->fetchLocationData($distributor->district_name);
            $locationData['full_name'] = $distributor->full_name;
            $locationData['address'] = $distributor->address;
            $locationData['primary_phone'] = $distributor->primary_phone;
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


    private function fetchLocationData($locationName)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json, text/plain, */*',
            'Use-Api-Key' => 'true',
        ])->get("https://popaket.com/service/logistic/v2/public/location", [
                    'name' => $locationName
                ]);

        return $response->successful() ? $response->json()['data']['locations'][0] : null;
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

            $regularRates = array_filter($rates, function ($rate) {
                return $rate['rate_type_name'] == 'Reguler';
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

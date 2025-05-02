<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CalculateShippingCostController extends Controller
{
    public function index()
    {
        return view('calculate_shipping_cost.index');
    }
    public function getProvinces()
    {
        return Province::select('id', 'name')->get();
    }

    public function getRegencies(Request $request)
    {
        return Regency::where('province_id', $request->province_id)
            ->select('id', 'name')
            ->get();
    }

    public function getDistricts(Request $request)
    {
        return District::where('regency_id', $request->regency_id)
            ->select('id', 'name')
            ->get();
    }

    public function getNearbyDistributors(Request $request)
    {
        $districtId = $request->district_id;

        if (!$districtId) {
            return response()->json(['error' => 'district_id is required'], 400);
        }

        $origin = DB::table('districts')
            ->where('id', $districtId)
            ->select('latitude', 'longitude')
            ->first();

        if (!$origin || !$origin->latitude || !$origin->longitude) {
            return response()->json(['error' => 'Invalid or incomplete district data'], 400);
        }

        $distributors = DB::table('distributors')
            ->join('districts', 'distributors.district_id', '=', 'districts.id')
            ->select(
                'distributors.*',
                DB::raw("(
                    6371 * acos(
                        cos(radians($origin->latitude)) *
                        cos(radians(districts.latitude)) *
                        cos(radians(districts.longitude) - radians($origin->longitude)) +
                        sin(radians($origin->latitude)) *
                        sin(radians(districts.latitude))
                    )
                ) AS distance_km")
            )
            ->whereNotNull('districts.latitude')
            ->whereNotNull('districts.longitude')
            ->orderBy('distance_km')
            ->limit(6)
            ->get();

        return response()->json($distributors);
    }

    public function calculateShippingCost(Request $request)
    {
        $distributor = $this->getDistributor($request->agent_id);
        if (!$distributor) {
            return response()->json(['error' => 'Distributor not found'], 404);
        }
        $destinationDistrict = $this->getDistrict($request->district_id);
        if (!$destinationDistrict) {
            return response()->json(['error' => 'Destination district not found'], 404);
        }
        $originLocation = $this->getLocationData($distributor);
        $destinationLocation = $this->getLocationDataFromDistrict($destinationDistrict);

        if (!$originLocation || !$destinationLocation) {
            return response()->json(['error' => 'Unable to fetch location data'], 400);
        }
        return $this->getShippingRate(
            $originLocation['sub_district_id'],
            $destinationLocation['sub_district_id'],
            $request->input('weight', 1)
        );
    }

    private function getDistributor($agentId)
    {
        return Distributor::where('id', $agentId)
            ->with('district.regency.province')
            ->first();
    }

    private function getDistrict($districtId)
    {
        return District::where('id', $districtId)
            ->with('regency.province')
            ->first();
    }

    private function getLocationData($distributor)
    {
        $originLocationName = $distributor->district->name . ', ' . $distributor->regency->name . ', ' . $distributor->regency->province->name;

        return $this->fetchLocationData($originLocationName);
    }

    private function getLocationDataFromDistrict($district)
    {
        $destinationLocationName = $district->name . ', ' . $district->regency->name . ', ' . $district->regency->province->name;

        return $this->fetchLocationData($destinationLocationName);
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
    
                return response()->json($filteredRates);
            }
    
            return response()->json(['error' => 'No regular rates found'], 404);
        }
    
        return response()->json(['error' => 'Unable to fetch shipping rate'], $response->status());
    }
    


}

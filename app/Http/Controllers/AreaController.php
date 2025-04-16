<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AreaController extends Controller
{

    public function insertProvince()
    {
        $url = 'https://raw.githubusercontent.com/yusufsyaifudin/wilayah-indonesia/master/data/list_of_area/provinces.json';

        $response = Http::get($url);

        if (!$response->successful()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch provinces'
            ], 500);
        }

        $provinces = $response->json();
        foreach ($provinces as $province) {
            if (!Province::find($province['id'])) {
                $store = new Province();
                $store->id = $province['id'];
                $store->name = $province['name'];
                $store->alt_name = $province['alt_name'];
                $store->latitude = $province['latitude'];
                $store->longitude = $province['longitude'];
                $store->save();
            }
        }
        

        return response()->json([
            'status' => true,
            'message' => 'Provinces imported successfully'
        ]);
    }

    public function insertRegency()
    {
        $url = 'https://raw.githubusercontent.com/yusufsyaifudin/wilayah-indonesia/master/data/list_of_area/regencies.json';

        $response = Http::get($url);

        if (!$response->successful()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch regencies'
            ], 500);
        }

        $regencies = $response->json();

        foreach ($regencies as $regency) {
            if (!Province::find($regency['province_id'])) {
                continue;
            }

            if (!Regency::find($regency['id'])) {
                $store = new Regency();
                $store->id = $regency['id'];
                $store->province_id = $regency['province_id'];
                $store->name = $regency['name'];
                $store->alt_name = $regency['alt_name'];
                $store->latitude = $regency['latitude'];
                $store->longitude = $regency['longitude'];
                $store->save();
            }
        }
        
        

        return response()->json([
            'status' => true,
            'message' => 'Regencies imported successfully'
        ]);
    }
    
    
    public function insertDistrict()
    {
        $url = 'https://raw.githubusercontent.com/yusufsyaifudin/wilayah-indonesia/master/data/list_of_area/districts.json';

        $response = Http::get($url);

        if (!$response->successful()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch regencies'
            ], 500);
        }

        $districts = $response->json();

        foreach ($districts as $district) {
            if (!Regency::find($district['regency_id'])) {
                continue;
            }
        
            if (!District::find($district['id'])) {
                $store = new District();
                $store->id = $district['id'];
                $store->regency_id = $district['regency_id'];
                $store->name = $district['name'];
                // $store->slug = Str::slug($district['name']);
                $store->alt_name = $district['alt_name'] ?? null;
                $store->latitude = $district['latitude'];
                $store->longitude = $district['longitude'];
                $store->save();
            }
        }        

        return response()->json([
            'status' => true,
            'message' => 'Regencies imported successfully'
        ]);
    }
    
    public function insertVillage()
    {
        set_time_limit(600000);
        $url = 'https://raw.githubusercontent.com/yusufsyaifudin/wilayah-indonesia/refs/heads/master/data/list_of_area/villages.json';

        $response = Http::get($url);

        if (!$response->successful()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch regencies'
            ], 500);
        }

        $villages = $response->json();
        // return $villages;
        foreach ($villages as $village) {
            if (!District::find($village['district_id'])) {
                continue;
            }
        
            if (!Village::find($village['id'])) {
                $store = new Village();
                $store->id = $village['id'];
                $store->district_id = $village['district_id'];
                $store->name = $village['name'];
                $store->latitude = $village['latitude'];
                $store->longitude = $village['longitude'];
                $store->save();
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Regencies imported successfully'
        ]);
    }
    public function listOfArea(Request $request)
    {
        if ($request->has('district_id')) {
            return response()->json([
                'status' => true,
                'level' => 'village',
                'data' => Village::where('district_id', $request->district_id)->get()
            ]);
        }

        if ($request->has('regency_id')) {
            return response()->json([
                'status' => true,
                'level' => 'district',
                'data' => District::where('regency_id', $request->regency_id)->get()
            ]);
        }

        if ($request->has('province_id')) {
            return response()->json([
                'status' => true,
                'level' => 'regency',
                'data' => Regency::where('province_id', $request->province_id)->get()
            ]);
        }

        return response()->json([
            'status' => true,
            'level' => 'province',
            'data' => Province::all()
        ]);
    }
}

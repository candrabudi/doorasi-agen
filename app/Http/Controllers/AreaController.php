<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;

class AreaController extends Controller
{
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

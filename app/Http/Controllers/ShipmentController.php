<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::latest()->get();
        return view('shipments.index', compact('shipments'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:shipments,code',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('shipments.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validation failed. Please check your input.');
        }

        try {
            DB::beginTransaction();

            $data = $request->only(['name', 'code', 'description', 'is_active']);
            $data['is_active'] = $request->has('is_active');

            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/icons', $filename);
                $data['icon'] = $filename;
            }

            Shipment::create($data);

            DB::commit();
            return redirect()->route('shipments.index')->with('success', 'Shipment created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Shipment store error: ' . $e->getMessage());
            return redirect()->route('shipments.index')->with('error', 'Failed to create shipment.');
        }
    }

    public function update(Request $request, $id)
    {
        $shipment = Shipment::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => "required|string|max:50|unique:shipments,code,$id",
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('shipments.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validation failed. Please check your input.');
        }

        try {
            DB::beginTransaction();

            $data = $request->only(['name', 'code', 'description', 'is_active']);
            $data['is_active'] = $request->has('is_active');

            if ($request->hasFile('icon')) {
                // Delete old icon if exists
                if ($shipment->icon && Storage::exists('public/icons/' . $shipment->icon)) {
                    Storage::delete('public/icons/' . $shipment->icon);
                }

                $file = $request->file('icon');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/icons', $filename);
                $data['icon'] = $filename;
            }

            $shipment->update($data);

            DB::commit();
            return redirect()->route('shipments.index')->with('success', 'Shipment updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Shipment update error: ' . $e->getMessage());
            return redirect()->route('shipments.index')->with('error', 'Failed to update shipment.');
        }
    }

    public function destroy($a)
    {
        $shipment = Shipment::where('id', $a)
            ->first();
        try {
            if ($shipment->icon && Storage::exists('public/icons/' . $shipment->icon)) {
                Storage::delete('public/icons/' . $shipment->icon);
            }

            $shipment->delete();
            return redirect()->route('shipments.index')->with('success', 'Shipment deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Shipment delete error: ' . $e->getMessage());
            return redirect()->route('shipments.index')->with('error', 'Failed to delete shipment.');
        }
    }
}

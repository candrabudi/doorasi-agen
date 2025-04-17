<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\DistributorShipment;
use App\Models\Province;
use App\Models\Shipment;
use App\Models\User;
use App\Models\MarketPlace;
use Illuminate\Http\Request;
use Illuminate\Support\FacadesDB;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DistributorController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'distributor')->get();
        return view('distributors.index', compact('users'));
    }

    public function edit($user_id)
    {
        $distributor = Distributor::where('user_id', $user_id)->firstOrFail();
        $user = $distributor->user;

        return view('distributors.edit', [
            'distributor' => $distributor,
            'user' => $user,
            'provinces' => Province::all(),
            'marketPlaces' => MarketPlace::all(),
            'marketPlaceUrls' => $distributor->marketPlaces->pluck('pivot.url', 'id')->toArray(),
            'shipments' => Shipment::where('is_active', true)->get(),
            'selectedShippingMethods' => $distributor->shipments->pluck('id')->toArray(),
        ]);
    }


    public function create()
    {
        $provinces = Province::all();
        $shipments = Shipment::all();
        $marketPlaces = MarketPlace::all();

        return view('distributors.create', compact('shipments', 'marketPlaces', 'provinces'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:6',
            'phone_number' => 'required|string|max:15',
            // 'role' => 'required|in:admin,distributor',
            'status' => 'nullable|boolean',
            'full_name' => 'required|string|max:255',
            'primary_phone' => 'nullable|string|max:15',
            'distributor_email' => 'nullable|email|max:255',
            'agent_code' => 'nullable|string|max:255',
            'google_maps_url' => 'nullable|url',
            'address' => 'nullable|string|max:1000',
            'is_cod' => 'nullable|boolean',
            'is_shipping' => 'nullable|boolean',
            'shipping_methods' => 'nullable|array',
            'market_places' => 'nullable|array',
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required|exists:regencies,id',
            'district_id' => 'required|exists:districts,id',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : null,
                'phone_number' => $validatedData['phone_number'],
                'status' => $validatedData['status'] ?? 0,
                'role' => 'distributor'
            ]);

            $distributor = Distributor::create([
                'user_id' => $user->id,
                'full_name' => $validatedData['full_name'],
                'primary_phone' => $validatedData['primary_phone'],
                'email' => $validatedData['distributor_email'],
                'agent_code' => $validatedData['agent_code'],
                'google_maps_url' => $validatedData['google_maps_url'],
                'address' => $validatedData['address'],
                'is_cod' => $validatedData['is_cod'] ?? 0,
                'is_shipping' => $validatedData['is_shipping'] ?? 0,
                'province_id' => $validatedData['province_id'],
                'regency_id' => $validatedData['regency_id'],
                'district_id' => $validatedData['district_id'],
                // 'village_id' => $validatedData['village_id'],
            ]);

            if ($distributor->is_shipping && !empty($validatedData['shipping_methods'])) {
                foreach ($validatedData['shipping_methods'] as $shippingMethodId) {
                    DB::table('distributor_shipments')->insert([
                        'distributor_id' => $distributor->id,
                        'shipment_id' => $shippingMethodId,
                    ]);
                }
            }

            if (!empty($validatedData['market_places'])) {
                foreach ($validatedData['market_places'] as $marketPlaceId => $data) {
                    if (!empty($data['enabled'])) {
                        DB::table('distributor_market_places')->insert([
                            'distributor_id' => $distributor->id,
                            'market_place_id' => $marketPlaceId,
                            'url' => $data['url'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }


            DB::commit();

            return redirect()->route('distributors.index')->with('success', 'User and distributor profile created successfully!');
        } catch (\Exception $e) {
            return $e->getMessage();
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'There was an error creating the user or distributor profile.']);
        }
    }

    public function update(Request $request, $id)
    {
        $distributor = Distributor::where('user_id',$id)
            ->first();
        $user = $distributor->user;

        $request->validate([
            'full_name' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'regency_id' => 'required',
            'district_id' => 'required',
            // 'village_id' => 'required',
        ]);

        $distributor->update([
            'full_name' => $request->full_name,
            'primary_phone' => $request->primary_phone,
            // 'secondary_phone' => $request->secondary_phone,
            'distributor_email' => $request->distributor_email,
            'agent_code' => $request->agent_code,
            'google_maps_url' => $request->google_maps_url,
            'address' => $request->address,
            'is_cod' => $request->has('is_cod'),
            'is_shipping' => $request->has('is_shipping'),
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'district_id' => $request->district_id,
            // 'village_id' => $request->village_id,
        ]);

        if($request->shipping_methods) {
            DistributorShipment::where('distributor_id', $distributor->id)
                ->delete();
            foreach($request->shipping_methods as $shm) {
                DistributorShipment::create([
                    'distributor_id' => $distributor->id, 
                    'shipment_id' => $shm
                ]);
            }
        }
        $marketPlaces = [];
        if ($request->has('market_places')) {
            foreach ($request->market_places as $id => $data) {
                if (isset($data['enabled'])) {
                    $marketPlaces[$id] = ['url' => $data['url'] ?? null];
                }
            }
        }
        $distributor->marketPlaces()->sync($marketPlaces);
        return redirect()->route('distributors.index')->with('success', 'Distributor updated successfully.');
    }


    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            if ($user->distributor) {
                $user->distributor->shipments()->detach();
                $user->distributor->marketPlaces()->detach();
                $user->distributor->delete();
            }
            $user->delete();
            DB::commit();

            return redirect()->route('distributors.index')->with('success', 'Distributor berhasil dihapus.');

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting distributor: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus data distributor. Silakan coba lagi.']);
        }
    }
}

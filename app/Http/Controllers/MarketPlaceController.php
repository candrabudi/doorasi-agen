<?php

namespace App\Http\Controllers;

use App\Models\MarketPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarketPlaceController extends Controller
{
    // Menampilkan semua marketplace
    public function index()
    {
        $marketPlaces = MarketPlace::all();
        return view('marketplaces.index', compact('marketPlaces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Mengupload file gambar
        $iconName = time() . '.' . $request->icon->extension();
        $request->icon->storeAs('public/icons', $iconName);

        // Menyimpan marketplace
        MarketPlace::create([
            'name' => $request->name,
            'icon' => $iconName,
        ]);

        return redirect()->route('marketplaces.index')->with('success', 'Marketplace created successfully.');
    }

    // Menyimpan perubahan marketplace
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $marketPlace = MarketPlace::findOrFail($id);

        // Jika ada file gambar baru, lakukan upload dan update icon
        if ($request->hasFile('icon')) {
            // Hapus file gambar lama
            Storage::delete('public/icons/' . $marketPlace->icon);

            // Upload gambar baru
            $iconName = time() . '.' . $request->icon->extension();
            $request->icon->storeAs('public/icons', $iconName);

            $marketPlace->icon = $iconName;
        }

        // Update data marketplace
        $marketPlace->update([
            'name' => $request->name,
        ]);

        return redirect()->route('marketplaces.index')->with('success', 'Marketplace updated successfully.');
    }
    // Menghapus marketplace
    public function destroy($id)
    {
        $marketPlace = MarketPlace::findOrFail($id);
        $marketPlace->delete();

        return redirect()->route('marketplaces.index')->with('success', 'Marketplace deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\RentImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RentController extends Controller
{
    public function index()
    {
        return view('rents', [
            'title' => 'Kontrakan',
            'rents' => Rent::all()
        ]);
    }
    public function create(Rent $rent)
    {
        return view('rents.create',[
            'title' => 'Tambah Kontrakan',
            'rent' => $rent->load('detail'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'address' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'building_size' => 'required|integer',
            'electricity' => 'required|string',
            'water' => 'required|string',
        ]);


        $rent = Rent::create([
            'title' => $request->title,
            'address' => $request->address,
            'price' => $request->price,
            'slug' => Str::slug($request->title),
            'image' => null,
        ]);

        // Simpan gambar-gambar jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
            $path = $image->store('rents', 'public');

            // Simpan ke tabel rent_images
            $rent->images()->create([
                'path' => $path
                ]);

            // Jadikan gambar pertama sebagai 'image utama'
            if ($index === 0) {
                $rent->update(['image' => $path]);
                }
            }
        }

        $rent->detail()->create([
        'bedrooms' => $request->bedrooms,
        'bathrooms' => $request->bathrooms,
        'building_size' => $request->building_size,
        'electricity' => $request->electricity,
        'water' => $request->water,
        ]);

        Alert::success('Berhasil', 'Kontrakan berhasil ditambahkan!')->persistent();

        return redirect()->route('rents.create');
    }

    // Fungsi bulkDelete
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected_rents' => 'required|array',
            'selected_rents.*' => 'exists:rents,id',
        ]);

        Rent::whereIn('id', $request->selected_rents)->delete();

        Alert::success('Berhasil', 'Beberapa kontrakan berhasil dihapus!');
        return redirect()->route('rents.index'); 
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index(Request $request)
    {
        $wilayahs = Wilayah::when($request->q, function ($query) use ($request) {
                $query->where('city_name', 'like', "%{$request->q}%")
                      ->orWhere('airport_code', 'like', "%{$request->q}%");
            })
            ->orderBy('city_name')
            ->paginate(10)
            ->withQueryString();

        return view('wilayah.index', compact('wilayahs'));
    }

    public function create()
    {
        return view('wilayah.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'city_name'    => 'required|string|max:100',
            'airport_code' => 'required|string|max:5|unique:wilayahs,airport_code',
            'country'      => 'nullable|string|max:100',
        ]);

        Wilayah::create($data);

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil ditambahkan.');
    }

    public function edit(Wilayah $wilayah)
    {
        return view('wilayah.edit', compact('wilayah'));
    }

    public function update(Request $request, Wilayah $wilayah)
    {
        $data = $request->validate([
            'city_name'    => 'required|string|max:100',
            'airport_code' => 'required|string|max:5|unique:wilayahs,airport_code,' . $wilayah->id,
            'country'      => 'nullable|string|max:100',
        ]);

        $wilayah->update($data);

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil diperbarui.');
    }

    public function destroy(Wilayah $wilayah)
    {
        $used = \App\Models\Flight::where('origin_wilayah_id', $wilayah->id)
            ->orWhere('destination_wilayah_id', $wilayah->id)
            ->exists();

        if ($used) {
            return back()->with('error', 'Wilayah tidak bisa dihapus karena masih dipakai pada data penerbangan.');
        }

        $wilayah->delete();

        return back()->with('success', 'Wilayah berhasil dihapus.');
    }
}

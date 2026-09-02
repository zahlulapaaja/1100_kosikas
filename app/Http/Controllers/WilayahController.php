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
                ->orWhere('airport_name', 'like', "%{$request->q}%")
                ->orWhere('code_iata', 'like', "%{$request->q}%")
                ->orWhere('code_icao', 'like', "%{$request->q}%");
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
            'airport_name'   => 'required|string|max:150',
            'code_iata'      => 'required|string|max:3|unique:wilayahs,code_iata',
            'code_icao'      => 'required|string|max:4|unique:wilayahs,code_icao',
            'city_name'      => 'required|string|max:100',
            'province_name'  => 'nullable|string|max:100',
            'country'        => 'nullable|string|max:100',
            'latitude'       => 'nullable|numeric|between:-90,90',
            'longitude'      => 'nullable|numeric|between:-180,180',
            'timezone'       => 'nullable|string|max:50',
            'type'           => 'required|in:domestic,international',
            'is_active'      => 'nullable|boolean',
        ]);

        $data['code_iata'] = strtoupper($data['code_iata']);
        $data['code_icao'] = strtoupper($data['code_icao']);
        $data['is_active'] = $request->boolean('is_active');

        Wilayah::create($data);

        return redirect()->route('travel.wilayah.index')->with('success', 'Wilayah berhasil ditambahkan.');
    }

    public function edit(Wilayah $wilayah)
    {
        return view('wilayah.edit', compact('wilayah'));
    }

    public function update(Request $request, Wilayah $wilayah)
    {
        $data = $request->validate([
            'airport_name'   => 'required|string|max:150',
            'code_iata'      => 'required|string|max:3|unique:wilayahs,code_iata,' . $wilayah->id,
            'code_icao'      => 'required|string|max:4|unique:wilayahs,code_icao,' . $wilayah->id,
            'city_name'      => 'required|string|max:100',
            'province_name'  => 'nullable|string|max:100',
            'country'        => 'nullable|string|max:100',
            'latitude'       => 'nullable|numeric|between:-90,90',
            'longitude'      => 'nullable|numeric|between:-180,180',
            'timezone'       => 'nullable|string|max:50',
            'type'           => 'required|in:domestic,international',
            'is_active'      => 'nullable|boolean',
        ]);

        $data['code_iata'] = strtoupper($data['code_iata']);
        $data['code_icao'] = strtoupper($data['code_icao']);
        $data['is_active'] = $request->boolean('is_active');

        $wilayah->update($data);

        return redirect()->route('travel.wilayah.index')->with('success', 'Wilayah berhasil diperbarui.');
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

<?php

namespace App\Http\Controllers;

use App\Models\Maskapai;
use Illuminate\Http\Request;

class MaskapaiController extends Controller
{
    public function index(Request $request)
    {
        $maskapais = Maskapai::when($request->q, function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->q}%")
                      ->orWhere('code', 'like', "%{$request->q}%");
            })
            ->withCount('flights')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('maskapai.index', compact('maskapais'));
    }

    public function create()
    {
        return view('maskapai.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:10|unique:maskapais,code',
        ]);

        Maskapai::create($data);

        return redirect()->route('maskapai.index')->with('success', 'Maskapai berhasil ditambahkan.');
    }

    public function edit(Maskapai $maskapai)
    {
        return view('maskapai.edit', compact('maskapai'));
    }

    public function update(Request $request, Maskapai $maskapai)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:10|unique:maskapais,code,' . $maskapai->id,
        ]);

        $maskapai->update($data);

        return redirect()->route('maskapai.index')->with('success', 'Maskapai berhasil diperbarui.');
    }

    public function destroy(Maskapai $maskapai)
    {
        if ($maskapai->flights()->exists()) {
            return back()->with('error', 'Maskapai tidak bisa dihapus karena masih dipakai pada data penerbangan.');
        }

        $maskapai->delete();

        return back()->with('success', 'Maskapai berhasil dihapus.');
    }
}

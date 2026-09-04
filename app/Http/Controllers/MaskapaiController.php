<?php

namespace App\Http\Controllers;

use App\Models\Maskapai;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class MaskapaiController extends Controller
{
    public function index(Request $request)
    {
        $maskapais = Maskapai::when($request->q, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->q}%")
                ->orWhere('code_iata', 'like', "%{$request->q}%")
                ->orWhere('code_icao', 'like', "%{$request->q}%");
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
            'name'      => 'required|string|max:100',
            'code_iata' => 'required|string|max:10|unique:maskapais,code_iata',
            'code_icao' => 'required|string|max:10|unique:maskapais,code_icao',
            'logo'      => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $data['code_iata'] = strtoupper($data['code_iata']);
        $data['code_icao'] = strtoupper($data['code_icao']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->storeLogo($request->file('logo'), $data['code_iata']);
        }

        Maskapai::create($data);

        return redirect()->route('travel.maskapai.index')->with('success', 'Maskapai berhasil ditambahkan.');
    }

    public function edit(Maskapai $maskapai)
    {
        return view('maskapai.edit', compact('maskapai'));
    }

    public function update(Request $request, Maskapai $maskapai)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'code_iata' => 'required|string|max:10|unique:maskapais,code_iata,' . $maskapai->id,
            'code_icao' => 'required|string|max:10|unique:maskapais,code_icao,' . $maskapai->id,
            'logo'      => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $data['code_iata'] = strtoupper($data['code_iata']);
        $data['code_icao'] = strtoupper($data['code_icao']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->storeLogo($request->file('logo'), $data['code_iata']);
        } elseif ($maskapai->logo && $data['code_iata'] !== $maskapai->code_iata) {
            // Kode IATA diubah tapi logo tidak diupload ulang — samakan nama file
            // lama supaya tetap sinkron dengan konvensi {code_iata}.{ext} yang
            // dibaca otomatis oleh template PDF e-ticket.
            $renamed = $this->renameLogo($maskapai->logo, $data['code_iata']);
            if ($renamed) {
                $data['logo'] = $renamed;
            }
        }

        $maskapai->update($data);

        return redirect()->route('travel.maskapai.index')->with('success', 'Maskapai berhasil diperbarui.');
    }

    public function destroy(Maskapai $maskapai)
    {
        if ($maskapai->flights()->exists()) {
            return back()->with('error', 'Maskapai tidak bisa dihapus karena masih dipakai pada data penerbangan.');
        }

        if ($maskapai->logo && file_exists(public_path($maskapai->logo))) {
            @unlink(public_path($maskapai->logo));
        }

        $maskapai->delete();

        return back()->with('success', 'Maskapai berhasil dihapus.');
    }

    /**
     * Simpan file logo ke public/images/airlines, dinamai sesuai kode IATA
     * (mis. IU.png) supaya otomatis terbaca oleh template PDF e-ticket tanpa
     * perlu konfigurasi tambahan.
     */
    private function storeLogo(UploadedFile $file, string $codeIata): string
    {
        $directory = public_path('images/airlines');
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Bersihkan logo lama dengan ekstensi apa pun sebelum simpan yang baru,
        // supaya tidak ada file basi (mis. IU.jpg lama nyangkut setelah upload IU.png).
        foreach (['png', 'jpg', 'jpeg', 'webp'] as $ext) {
            $old = $directory . '/' . $codeIata . '.' . $ext;
            if (file_exists($old)) {
                @unlink($old);
            }
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $filename  = $codeIata . '.' . $extension;

        $file->move($directory, $filename);

        return 'images/airlines/' . $filename;
    }

    /**
     * Ganti nama file logo yang sudah ada mengikuti kode IATA baru.
     */
    private function renameLogo(string $oldRelativePath, string $newCode): ?string
    {
        $directory = public_path('images/airlines');
        $extension = pathinfo($oldRelativePath, PATHINFO_EXTENSION);
        $oldFull   = public_path($oldRelativePath);
        $newFull   = $directory . '/' . $newCode . '.' . $extension;

        if (file_exists($oldFull)) {
            rename($oldFull, $newFull);

            return 'images/airlines/' . $newCode . '.' . $extension;
        }

        return null;
    }
}

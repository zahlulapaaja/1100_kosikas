<?php

namespace App\Http\Controllers;

use App\Models\Penerbangan;
use App\Models\Maskapai;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class PenerbanganController extends Controller
{
    /**
     * Halaman daftar penerbangan
     */
    public function index(Request $request)
    {
        $wilayahs = Wilayah::where('is_active', true)
            ->orderByRaw("
                CASE
                    WHEN code_iata = 'BTJ' THEN 1
                    WHEN code_iata = 'KNO' THEN 2
                    WHEN code_iata = 'CGK' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('city_name')
            ->get();

        $jadwals = collect();

        if ($request->filled('wilayah_asal_id') && $request->filled('wilayah_tujuan_id')) {

            $jadwals = Penerbangan::with([
                'asal',
                'tujuan',
                'maskapai'
            ])
                ->where('wilayah_asal_id', $request->wilayah_asal_id)
                ->where('wilayah_tujuan_id', $request->wilayah_tujuan_id)
                ->orderBy('jam_berangkat')
                ->get();
        }

        return view('penerbangan.index', compact(
            'wilayahs',
            'jadwals'
        ));
    }

    /**
     * Halaman form tambah jadwal
     */
    public function create(Request $request)
    {
        $wilayahAsal = Wilayah::findOrFail(
            $request->wilayah_asal_id
        );

        $wilayahTujuan = Wilayah::findOrFail(
            $request->wilayah_tujuan_id
        );

        $maskapais = Maskapai::orderBy('name')->get();

        return view('penerbangan.create', compact(
            'wilayahAsal',
            'wilayahTujuan',
            'maskapais'
        ));
    }

    /**
     * Simpan jadwal penerbangan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wilayah_asal_id' => 'required|exists:wilayahs,id',
            'wilayah_tujuan_id' => 'required|exists:wilayahs,id',
            'maskapai_id' => 'required|exists:maskapais,id',
            'jam_berangkat' => 'required|date_format:H:i',
            'jam_sampai' => 'required|date_format:H:i',
        ]);

        // Cegah jadwal duplikat (mis. akibat submit dobel)
        $duplikat = Penerbangan::where('wilayah_asal_id', $validated['wilayah_asal_id'])
            ->where('wilayah_tujuan_id', $validated['wilayah_tujuan_id'])
            ->where('maskapai_id', $validated['maskapai_id'])
            ->where('jam_berangkat', $validated['jam_berangkat'])
            ->exists();

        if ($duplikat) {
            return back()
                ->withInput()
                ->withErrors([
                    'jam_berangkat' => 'Jadwal dengan maskapai dan jam berangkat yang sama sudah ada di rute ini.'
                ]);
        }

        Penerbangan::create($validated);

        return redirect()
            ->route('travel.penerbangan.index', [
                'wilayah_asal_id' => $validated['wilayah_asal_id'],
                'wilayah_tujuan_id' => $validated['wilayah_tujuan_id'],
            ])
            ->with('success', 'Jadwal penerbangan berhasil ditambahkan.');
    }

    /**
     * Halaman form edit jadwal
     */
    public function edit(Penerbangan $penerbangan)
    {
        $penerbangan->load(['asal', 'tujuan', 'maskapai']);

        $maskapais = Maskapai::orderBy('name')->get();

        return view('penerbangan.edit', compact(
            'penerbangan',
            'maskapais'
        ));
    }

    /**
     * Update jadwal penerbangan
     */
    public function update(Request $request, Penerbangan $penerbangan)
    {
        $validated = $request->validate([
            'maskapai_id' => 'required|exists:maskapais,id',
            'jam_berangkat' => 'required|date_format:H:i',
            'jam_sampai' => 'required|date_format:H:i',
        ]);

        // Cegah duplikat terhadap jadwal lain di rute yang sama
        $duplikat = Penerbangan::where('wilayah_asal_id', $penerbangan->wilayah_asal_id)
            ->where('wilayah_tujuan_id', $penerbangan->wilayah_tujuan_id)
            ->where('maskapai_id', $validated['maskapai_id'])
            ->where('jam_berangkat', $validated['jam_berangkat'])
            ->where('id', '!=', $penerbangan->id)
            ->exists();

        if ($duplikat) {
            return back()
                ->withInput()
                ->withErrors([
                    'jam_berangkat' => 'Jadwal dengan maskapai dan jam berangkat yang sama sudah ada di rute ini.'
                ]);
        }

        $penerbangan->update($validated);

        return redirect()
            ->route('travel.penerbangan.index', [
                'wilayah_asal_id' => $penerbangan->wilayah_asal_id,
                'wilayah_tujuan_id' => $penerbangan->wilayah_tujuan_id,
            ])
            ->with('success', 'Jadwal penerbangan berhasil diperbarui.');
    }

    /**
     * Hapus jadwal
     */
    public function destroy(Penerbangan $penerbangan)
    {
        $asal = $penerbangan->wilayah_asal_id;
        $tujuan = $penerbangan->wilayah_tujuan_id;

        $penerbangan->delete();

        return redirect()
            ->route('travel.penerbangan.index', [
                'wilayah_asal_id' => $asal,
                'wilayah_tujuan_id' => $tujuan,
            ])
            ->with('success', 'Jadwal penerbangan berhasil dihapus.');
    }
}

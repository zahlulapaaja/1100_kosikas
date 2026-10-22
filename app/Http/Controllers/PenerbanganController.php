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
                'maskapai',
                'transit',
                'transitMaskapai',
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

        $wilayahTransits = $this->daftarWilayahTransit(
            $wilayahAsal->id,
            $wilayahTujuan->id
        );

        return view('penerbangan.create', compact(
            'wilayahAsal',
            'wilayahTujuan',
            'maskapais',
            'wilayahTransits'
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
        ] + $this->aturanTransit());

        if ($error = $this->cekDurasiTransit($request)) {
            return $error;
        }

        Penerbangan::create($this->normalisasiTransit($validated, $request));

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
        $penerbangan->load(['asal', 'tujuan', 'maskapai', 'transit', 'transitMaskapai']);

        $maskapais = Maskapai::orderBy('name')->get();

        $wilayahTransits = $this->daftarWilayahTransit(
            $penerbangan->wilayah_asal_id,
            $penerbangan->wilayah_tujuan_id
        );

        return view('penerbangan.edit', compact(
            'penerbangan',
            'maskapais',
            'wilayahTransits'
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
        ] + $this->aturanTransit($penerbangan));

        if ($error = $this->cekDurasiTransit($request)) {
            return $error;
        }

        $penerbangan->update($this->normalisasiTransit($validated, $request));

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

    /* =====================================================================
     |  Helper transit
     | ===================================================================== */

    /**
     * Daftar bandara yang boleh dipilih sebagai bandara transit
     * (tidak boleh sama dengan asal atau tujuan).
     */
    private function daftarWilayahTransit(int $asalId, int $tujuanId)
    {
        return Wilayah::where('is_active', true)
            ->whereNotIn('id', [$asalId, $tujuanId])
            ->orderBy('city_name')
            ->get();
    }

    /**
     * Aturan validasi field transit.
     *
     * - Saat tambah (store): asal/tujuan ada di request, pakai "different".
     * - Saat edit (update): asal/tujuan tidak ada di form, pakai "not_in"
     *   dengan data dari jadwal yang tersimpan.
     */
    private function aturanTransit(?Penerbangan $penerbangan = null): array
    {
        $aturanBandara = [
            'nullable',
            'required_if:punya_transit,1',
            'exists:wilayahs,id',
        ];

        if ($penerbangan) {
            $aturanBandara[] = 'not_in:' . $penerbangan->wilayah_asal_id . ',' . $penerbangan->wilayah_tujuan_id;
        } else {
            $aturanBandara[] = 'different:wilayah_asal_id';
            $aturanBandara[] = 'different:wilayah_tujuan_id';
        }

        return [
            'punya_transit'       => 'nullable|boolean',
            'transit_wilayah_id'  => $aturanBandara,
            'transit_maskapai_id' => 'nullable|exists:maskapais,id',
            'transit_jam'         => 'nullable|integer|min:0|max:23',
            'transit_menit'       => 'nullable|integer|min:0|max:59',
        ];
    }

    /**
     * Lama transit wajib lebih dari 0 menit jika penerbangan transit.
     * Mengembalikan redirect error, atau null jika valid.
     */
    private function cekDurasiTransit(Request $request)
    {
        if (! $request->boolean('punya_transit')) {
            return null;
        }

        $durasi = ((int) $request->input('transit_jam', 0)) * 60
            + ((int) $request->input('transit_menit', 0));

        if ($durasi < 1) {
            return back()
                ->withInput()
                ->withErrors(['transit_jam' => 'Lama transit harus diisi.']);
        }

        return null;
    }

    /**
     * Ubah input form transit menjadi kolom database.
     * Jika tidak transit, semua kolom transit dikosongkan.
     */
    private function normalisasiTransit(array $validated, Request $request): array
    {
        $punyaTransit = $request->boolean('punya_transit');

        $durasi = ((int) ($validated['transit_jam'] ?? 0)) * 60
            + ((int) ($validated['transit_menit'] ?? 0));

        unset($validated['transit_jam'], $validated['transit_menit']);

        $validated['punya_transit']        = $punyaTransit;
        $validated['transit_wilayah_id']   = $punyaTransit ? ($validated['transit_wilayah_id'] ?? null) : null;
        $validated['transit_maskapai_id']  = $punyaTransit ? ($validated['transit_maskapai_id'] ?? null) : null;
        $validated['transit_durasi_menit'] = $punyaTransit ? $durasi : null;

        return $validated;
    }
}

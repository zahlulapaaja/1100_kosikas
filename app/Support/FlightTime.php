<?php

namespace App\Support;

use Carbon\Carbon;

/**
 * Waktu penerbangan dengan zona waktu bandara asal & tujuan.
 * Logikanya sama dengan blok flight di e-ticket (pdf.blade.php):
 *  - jam berangkat = jam lokal bandara asal, jam tiba = jam lokal bandara tujuan
 *  - kalau berangkat "lebih awal" dari tiba segmen sebelumnya (< 24 jam) = lewat tengah malam -> maju sehari
 *  - durasi dihitung dari selisih waktu absolut, bukan selisih jam di dinding
 *
 * Pemakaian:
 *   $legs = FlightTime::legs($booking->flights);   // flights urut berangkat, origin & destination sudah di-load
 *   $t = $legs[$flight->id];
 *   $t['dep']        Carbon di zona asal (null kalau jam berangkat kosong / gagal dihitung)
 *   $t['arr']        Carbon di zona tujuan (null kalau jam tiba kosong / gagal dihitung)
 *   $t['dep_label']  "MYT · UTC+8" (null kalau zona tidak diketahui)
 *   $t['arr_label']  "AST · UTC+3"
 *   $t['duration']   "7j 20m"
 */
class FlightTime
{
    private const ALIASES = [
        'WIB' => 'Asia/Jakarta',
        'WITA' => 'Asia/Makassar',
        'WIT' => 'Asia/Jayapura',
    ];

    private const ABBR = [
        'Asia/Jakarta' => 'WIB',
        'Asia/Pontianak' => 'WIB',
        'Asia/Makassar' => 'WITA',
        'Asia/Jayapura' => 'WIT',
        'Asia/Kuala_Lumpur' => 'MYT',
        'Asia/Kuching' => 'MYT',
        'Asia/Singapore' => 'SGT',
        'Asia/Bangkok' => 'ICT',
        'Asia/Ho_Chi_Minh' => 'ICT',
        'Asia/Manila' => 'PHT',
        'Asia/Hong_Kong' => 'HKT',
        'Asia/Tokyo' => 'JST',
        'Asia/Seoul' => 'KST',
        'Asia/Qatar' => 'AST',
        'Asia/Riyadh' => 'AST',
        'Asia/Dubai' => 'GST',
        'Asia/Kolkata' => 'IST',
    ];

    /** cadangan kalau kolom timezone hanya berisi offset (menit => singkatan) */
    private const OFFSET_ABBR = [420 => 'WIB', 480 => 'MYT', 180 => 'AST'];

    /**
     * @param  iterable  $flights  flights dari SATU booking, urut berangkat
     * @return array<int|string, array>  keyed by $flight->id
     */
    public static function legs(iterable $flights): array
    {
        $legs = [];
        $prevArr = null;

        foreach ($flights as $f) {
            $o = self::resolveTz($f->origin ?? null);
            $d = self::resolveTz($f->destination ?? null);

            $leg = [
                'dep' => null,
                'arr' => null,
                'duration' => null,
                'dep_abbr' => null,
                'dep_utc' => null,
                'dep_label' => null,
                'arr_abbr' => null,
                'arr_utc' => null,
                'arr_label' => null,
            ];

            $hasDep = trim((string) $f->dep_time) !== '';
            $hasArr = trim((string) $f->arr_time) !== '';

            try {
                $date = $f->departure_date->format('Y-m-d');
                $dep = Carbon::parse($date . ' ' . ($hasDep ? $f->dep_time : '00:00'), $o['id']);

                if ($hasDep) {
                    if ($prevArr && $dep->lt($prevArr) && ($prevArr->timestamp - $dep->timestamp) < 86400) {
                        $dep->addDay();
                    }
                    [$leg['dep_abbr'], $leg['dep_utc']] = self::parts($dep, $o);
                    $leg['dep_label'] = self::join($leg['dep_abbr'], $leg['dep_utc']);
                }
                $leg['dep'] = $dep;

                if ($hasDep && $hasArr) {
                    $arr = $dep->copy()->setTimezone($d['id'])->setTimeFromTimeString($f->arr_time);
                    if ($arr->lte($dep)) {
                        $arr->addDay();
                    }
                    $mins = intdiv($arr->timestamp - $dep->timestamp, 60);
                    $leg['arr'] = $arr;
                    $leg['duration'] = sprintf('%dj %02dm', intdiv($mins, 60), $mins % 60);
                    [$leg['arr_abbr'], $leg['arr_utc']] = self::parts($arr, $d);
                    $leg['arr_label'] = self::join($leg['arr_abbr'], $leg['arr_utc']);
                    $prevArr = $arr;
                }
            } catch (\Throwable $e) {
                // biarkan null -> pemanggil fallback ke departure_date
            }

            $legs[$f->id] = $leg;
        }

        return $legs;
    }

    /**
     * Terima model wilayah. Kolom timezone boleh berisi: IANA, WIB/WITA/WIT,
     * "UTC+8", "+08:00", "8". Kalau kosong dan bandara di Indonesia, zona
     * ditebak dari nama provinsi.
     */
    public static function resolveTz($w): array
    {
        $raw = trim((string) ($w->timezone ?? ''));

        if ($raw === '') {
            $country = strtolower(trim((string) ($w->country ?? '')));
            $prov = strtolower(trim((string) ($w->province_name ?? '')));

            if (in_array($country, ['indonesia', 'id'], true) && $prov !== '') {
                if (str_contains($prov, 'papua') || str_contains($prov, 'maluku')) {
                    return ['id' => 'Asia/Jayapura', 'known' => true];
                }
                foreach (
                    [
                        'bali',
                        'nusa tenggara',
                        'sulawesi',
                        'gorontalo',
                        'kalimantan selatan',
                        'kalimantan timur',
                        'kalimantan utara'
                    ] as $k
                ) {
                    if (str_contains($prov, $k)) {
                        return ['id' => 'Asia/Makassar', 'known' => true];
                    }
                }
                return ['id' => 'Asia/Jakarta', 'known' => true];
            }
            return ['id' => 'Asia/Jakarta', 'known' => false];
        }

        if (isset(self::ALIASES[strtoupper($raw)])) {
            return ['id' => self::ALIASES[strtoupper($raw)], 'known' => true];
        }

        if (preg_match('/^(?:UTC|GMT)?\s*([+-]?)\s*(\d{1,2})(?::?(\d{2}))?$/i', $raw, $m)) {
            return ['id' => sprintf('%s%02d:%02d', $m[1] ?: '+', $m[2], $m[3] ?? 0), 'known' => true];
        }

        return ['id' => $raw, 'known' => true];
    }

    /** [singkatan zona, "UTC+8"] untuk waktu tertentu */
    private static function parts(Carbon $t, array $tz): array
    {
        if (!$tz['known']) {
            return [null, null];
        }

        $min = $t->utcOffset();
        $abs = abs($min);
        $utc = 'UTC' . ($min < 0 ? '-' : '+') . intdiv($abs, 60)
            . ($abs % 60 ? ':' . sprintf('%02d', $abs % 60) : '');

        $abbr = self::ABBR[$t->getTimezone()->getName()] ?? null;
        if (!$abbr) {
            $abbr = $t->format('T'); // London -> GMT/BST otomatis (DST)
            if (!preg_match('/^[A-Za-z]{2,5}$/', $abbr)) {
                $abbr = self::OFFSET_ABBR[$min] ?? null;
            }
        }

        return [$abbr, $utc];
    }

    private static function join(?string $abbr, ?string $utc): ?string
    {
        if (!$utc) {
            return null;
        }
        return $abbr ? $abbr . ' · ' . $utc : $utc;
    }
}

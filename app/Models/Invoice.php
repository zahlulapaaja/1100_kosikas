<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'issued_date',
        'orderer_name',
        'orderer_address',
        'orderer_phone',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
        'signer_name',
        'notes',
    ];

    protected $casts = [
        'issued_date' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class)->orderBy('sort_order');
    }

    public function flightItems()
    {
        return $this->items()->where('type', 'flight');
    }

    public function extraItems()
    {
        return $this->items()->where('type', 'extra');
    }

    public function getTotalAttribute()
    {
        return $this->items->sum('amount');
    }

    public function getSortedFlightItemsAttribute()
    {
        $monthMap = [
            'jan' => 1,
            'feb' => 2,
            'mar' => 3,
            'apr' => 4,
            'mei' => 5,
            'jun' => 6,
            'jul' => 7,
            'agu' => 8,
            'agt' => 8,
            'sep' => 9,
            'okt' => 10,
            'nov' => 11,
            'des' => 12,
        ];

        return $this->flightItems->sortBy(function ($item) use ($monthMap) {
            $firstDatePart = trim(explode('/', $item->flight_date_text ?? '')[0] ?? '');

            // Cocokkan pola "10 Sep 2026"
            if (preg_match('/^(\d{1,2})\s+([A-Za-z]+)\s+(\d{4})$/u', $firstDatePart, $m)) {
                $day   = (int) $m[1];
                $month = $monthMap[mb_strtolower($m[2])] ?? null;
                $year  = (int) $m[3];

                if ($month) {
                    return sprintf('%04d-%02d-%02d', $year, $month, $day); // "2026-09-10" -> bisa diurutkan sebagai string
                }
            }

            // Format tak dikenali -> taruh di akhir
            return '9999-99-99';
        })->values();
    }
}

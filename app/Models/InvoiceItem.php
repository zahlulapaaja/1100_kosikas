<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'booking_id',
        'type',
        'passenger_name',
        'maskapai_name',
        'route_text',
        'flight_date_text',
        'label',
        'amount',
        'sort_order',

        // Hotel
        'hotel_name',
        'hotel_location',
        'checkin_date',
        'checkout_date',
    ];

    protected $casts = [
        'amount'        => 'decimal:2',
        'checkin_date'  => 'date',
        'checkout_date' => 'date',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * "10 Sep 2026 - 12 Sep 2026" atau "10 Sep 2026" kalau checkin = checkout.
     */
    public function getHotelDateRangeTextAttribute(): string
    {
        if (!$this->checkin_date) {
            return '-';
        }

        if (!$this->checkout_date || $this->checkin_date->isSameDay($this->checkout_date)) {
            return $this->checkin_date->translatedFormat('d M Y');
        }

        return $this->checkin_date->translatedFormat('d M Y') . ' - ' . $this->checkout_date->translatedFormat('d M Y');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'user_name',
        'email',
        'phone',
        'event_date',
        'location',
        'package_id',
        'total_price',
        'status',
        'payment_proof',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'total_price' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            if (blank($booking->booking_code)) {
                $booking->booking_code = static::generateBookingCode();
            }

            if (blank($booking->total_price) && $booking->package) {
                $booking->total_price = $booking->package->price;
            }
        });

        static::saving(function (Booking $booking) {
            $isBlockedDate = BlockedDate::query()
                ->whereDate('event_date', $booking->event_date)
                ->where('package_id', $booking->package_id)
                ->exists();

            if ($isBlockedDate) {
                throw ValidationException::withMessages([
                    'event_date' => 'Tanggal event tidak tersedia untuk paket ini.',
                ]);
            }

            if ($booking->status === 'confirmed') {
                $hasConflict = static::query()
                    ->whereDate('event_date', $booking->event_date)
                    ->where('package_id', $booking->package_id)
                    ->where('status', 'confirmed')
                    ->when($booking->exists, fn ($query) => $query->whereKeyNot($booking->id))
                    ->exists();

                if ($hasConflict) {
                    throw ValidationException::withMessages([
                        'event_date' => 'Tanggal ini sudah terkonfirmasi untuk paket yang dipilih.',
                    ]);
                }
            }
        });
    }

    public static function generateBookingCode(): string
    {
        do {
            $code = 'BK-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4));
        } while (static::query()->where('booking_code', $code)->exists());

        return $code;
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}

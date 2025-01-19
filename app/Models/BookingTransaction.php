<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BookingTransaction extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'phone_number',
        'booking_trx_id',
        'slug',
        'is_paid',
        'started_at',
        'total_amount',
        'duration',
        'ended_at',
        'office_space_id'
    ];

    public static function generateUniqueTrxId()
    {
        $prefix = 'FO';

        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx_id', $randomString)->exists());

        return $randomString;
    }

    public function officeSpace()
    {
        return $this->belongsTo(OfficeSpace::class, 'office_space_id');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}

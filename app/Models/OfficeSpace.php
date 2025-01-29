<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class OfficeSpace extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'thumbnail',
        'address',
        'slug',
        'is_open',
        'is_full_booked',
        'price',
        'duration',
        'about',
        'city_id',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function photos()
    {
        return $this->hasMany(OfficeSpacePhoto::class);
    }

    public function benefits()
    {
        return $this->hasMany(OfficeSpaceBenefit::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}

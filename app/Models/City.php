<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class City extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'photo',
        'slug',
    ];

    public function setNameAttribute($value) {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function officeSpaces()
    {
        return $this->hasMany(OfficeSpace::class);
    }

}

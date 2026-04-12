<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded = [];

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function subAreas()
    {
        return $this->hasMany(SubArea::class);
    }

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }
}

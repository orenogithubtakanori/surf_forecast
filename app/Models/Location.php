<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city', 'prefecture_id', 'shoreline_direction_id', 'latitude', 'longitude', 'landscape', 'parking'];

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanetStatus extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'index',
        'owner',
        'health',
        'regenPerSecond',
        'players',
        'created_at'
    ];

    // protected $hidden = [
    //     'id'
    // ];

    // public static function boot() {
    //     static::creating(function ($model) {
    //         $model->created_at = now()->timestamp;
    //     });
    // }
}

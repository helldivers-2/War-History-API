<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanetHistory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'planet_histories';

    protected $fillable = [
        'index',
        'owner',
        'warId',
        'health',
        'regenPerSecond',
        'players',
        'created_at'
    ];

    // protected $hidden = [
    //     'id'
    // ];
}

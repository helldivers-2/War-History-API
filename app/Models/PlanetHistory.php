<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanetHistory extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'planet_histories';

    protected $fillable = [
        'index',
        'owner',
        'warId',
        'health',
        'regenPerSecond',
        'players',
    ];
}

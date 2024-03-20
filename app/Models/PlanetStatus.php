<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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

    static function getAtTime(Carbon $datetime) {

        $planet_list = PlanetStatus::select('index')->distinct()->get();

        $planets = new Collection();

        foreach ($planet_list as $planet_index) {
            $planets->push(PlanetStatus::where('index', $planet_index->index)->where('created_at', '<=', $datetime)->latest()->first());
        }

        return $planets;
    }
}

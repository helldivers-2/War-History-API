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

    protected $hidden = [

    ];

    public function planet() {
        return $this->belongsTo(Planet::class, 'index', 'index');
    }

    public function campaigns() {
        error_log($this->created_at);
        return $this->hasMany(PlanetCampaign::class, 'planetIndex', 'index');
        }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanetCampaign extends Model
{
    use HasFactory;

    protected $table = 'planet_campaigns';

    protected $increments = false;

    protected $fillable = [
        'id',
        'planetIndex',
        'type',
        'count',
        'warId',
        'ended_at'
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function planet() {
        return $this->belongsTo(Planet::class, 'planetIndex', 'index');
    }
}

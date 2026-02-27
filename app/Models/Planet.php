<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Planet',
    properties: [
        new OA\Property(
            property: 'index',
            type: 'integer',
            example: 0,
        ),
        new OA\Property(
            property: 'warId',
            type: 'integer',
            example: 0,
        ),
        new OA\Property(
            property: 'owner',
            type: 'integer',
            example: 0,
        ),
        new OA\Property(
            property: 'health',
            type: 'number',
            example: 0,
        ),
        new OA\Property(
            property: 'regenPerSecond',
            type: 'number',
            example: 19.00,
        ),
        new OA\Property(
            property: 'players',
            type: 'integer',
            example: 53000,
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            example: '2024-06-12T16:23:24Z',
        ),
    ]
)]
class Planet extends Model
{
    use HasFactory;

    protected $table = 'planets';

    protected $primaryKey = 'index';

    public $incrementing = false;

    protected $fillable = [
        'index',
        'warId',
        'owner',
        'health',
        'regenPerSecond',
        'players',
        'created_at'
    ];

    protected $hidden = [
        'created_at',
    ];

    public function history() {
        return $this->hasMany(PlanetHistory::class, 'index', 'index');
    }

    public function campaigns() {
        return $this->hasMany(PlanetCampaign::class, 'planetIndex', 'index');
    }
}

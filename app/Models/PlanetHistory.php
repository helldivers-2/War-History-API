<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OpenApi\Attributes as OA;


#[OA\Schema(
    title: 'PlanetHistory',
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
            description: 'The time that specific entry was created'
        ),
        new OA\Property(
            property: 'updated_at',
            type: 'string',
            example: '2024-06-12T16:23:24Z',
            description: 'Last time this entry was updated. Can be newer than "last_valid" due to migrations'
        ),
        new OA\Property(
            property: 'valid_start',
            type: 'integer',
            example: 1711573202,
            description: 'The time that specific entry started being valid'
        ),
        new OA\Property(
            property: 'last_valid',
            type: 'integer',
            example: 1711574101,
            description: 'last time the entry was valid'
        ),
    ]
)]
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

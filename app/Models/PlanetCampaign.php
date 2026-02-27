<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'PlanetCampaign',
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
            example: 0,
        ),
        new OA\Property(
            property: 'planetIndex',
            type: 'integer',
            example: 0,
        ),
        new OA\Property(
            property: 'type',
            type: 'integer',
            example: 0,
        ),
        new OA\Property(
            property: 'count',
            type: 'integer',
            example: 0,
        ),
        new OA\Property(
            property: 'warId',
            type: 'integer',
            example: 0,
        ),
        new OA\Property(
            property: 'ended_at',
            type: 'string',
            example: '2024-06-14T16:31:30Z',
            nullable: true,
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            example: '2024-06-14T16:31:30Z',
        )
    ]
)]
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

    ];

    public function planet() {
        return $this->belongsTo(Planet::class, 'planetIndex', 'index');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Planet;
use App\Models\PlanetHistory;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use OpenApi\Attributes as OA;

class PlanetStatusController extends Controller
{

    #[OA\Get(
        path: '/api/planet/{planet_index}',
        summary: 'Returns the current status of the specified planet',
        tags: ['Planets'],
        parameters: [
            new OA\Parameter(
                name: 'planet_index',
                in: 'path',
                required: true,
                description: 'The index of the requested planet'
            )
        ],
        responses: [
            new OA\Response(
                description: 'The Planet has been found',
                response: 200,
                content: new OA\JsonContent(
                    ref: '#/components/schemas/PlanetHistory'
                )
            ),
            new OA\Response(
                description: 'The planet has not been found',
                response: 404,
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'error',
                            type: 'string',
                            example: 'Planet not found'
                        ),
                        new OA\Property(
                            property: 'code',
                            type: 'integer',
                            example: 404
                        )
                    ]
                )
            ),
            new OA\Response(
                description: 'Validation of your request failed',
                response: 422,
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Planet not found'
                        ),
                        new OA\Property(
                            property: 'errors',
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'planet_index',
                                    type: 'array',
                                    items: new OA\Items(
                                        type: 'string',
                                        example: 'The planet index field must be an integer.'
                                    )
                                )
                            ]
                        )
                    ]
                )
            )
        ]
    )]
    public function index(Request $request, $planet_index) {

        $request->merge(['planet_index' => $planet_index]);

        $request->validate([
            'planet_index' => ['integer', 'required'],
            'time' => ['date', 'nullable']
        ]);

        $time = $request->input('time') ? Carbon::parse($request->input('time')) : Carbon::now();

        error_log($time);

        $planetIndex = $request->input('planet_index');

        $planet = PlanetHistory::where('index', $planetIndex)
            ->where('updated_at', '<=', $time)
            ->orderBy('updated_at');

        error_log($planet->toSql());

        if ($planet->first()) {
            return response()->json($planet->first(), 200);
        } else {
            return response()->json([
                'error' => 'Planet not found',
                'code' => 404,
            ], 404);
        }

    }

    #[OA\Get(
        path: '/api/planet/{planet_index}/history',
        summary: 'returns the history',
        tags: ['Planets'],
        responses: [
            new OA\Response(
                description: 'Returns the history of a planet',
                response: 200,
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                ref: '#/components/schemas/PlanetHistory'
                            )
                        ),
                        new OA\Property(
                            property: 'size',
                            type: 'integer',
                            example: 50
                        ),
                        new OA\Property(
                            property: 'previous_page_url',
                            type: 'string',
                            example: 'https://  api-helldivers.kejax.net/api/planet/0/history?cursor=eyJwbGFuZXRfaGlzdG9yaWVzLmlkIjo0ODQsIl9wb2ludHNUb05leHRJdGVtcyI6dHJ1ZX0'
                        )
                    ]
                )
            )
        ]
    )]
    public function planetHistory(Request $request, $planet_index) {
        // Returns the history for the specifiec planet

        // Validation
        $request->validate([
            'size' => ['nullable', 'integer'],
            'cursor' => ['nullable', 'string']
        ]);

        // Limit the size to 100 with a default of 50
        $limit = min($request->input('size', 10), 100);

        // Get the Planet
        $planet = Planet::where('index', $planet_index)->first();

        // If the planet does not exist, return a 404 error
        // If the planet does exist, return a cursor with the history data
        if (!$planet) {
            return response()->json([
                'error' => 'planet_index is not valid',
                'code' => 404
            ], 404);
        } else {

            $cursor = $planet->history()->cursorPaginate($limit);

            return response()->json([
                'data' => $cursor->items(),
                'size' => $cursor->count(),
                'previous_page_url' => $cursor->previousPageUrl(),
                'previous_cursor' => $cursor->previousCursor(),
                'next_page_url' => $cursor->nextPageUrl(),
                'next_cursor' => $cursor->nextCursor(),
            ], 200);
        }

    }

    #[OA\Get(
        path: '/api/planets',
        summary: 'Returns all currently valid PlanetHistory or to that specific time, if `time` query is present',
        tags: ['Planets'],
        parameters: [
            new OA\Parameter(
                name: 'time',
                in: 'query',
                required: false,
                description: 'The time to query'
            )
        ],
        responses: [
            new OA\Response(
                description: 'The Planet has been found',
                response: 200,
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: '#/components/schemas/PlanetHistory'
                    )
                )
            ),
            new OA\Response(
                description: 'No valid entries have been found',
                response: 404,
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'error',
                            type: 'string',
                            example: 'No valid entries could be found for this time'
                        ),
                        new OA\Property(
                            property: 'code',
                            type: 'integer',
                            example: 404
                        )
                    ]
                )
            ),
            new OA\Response(
                description: 'Validation of your request failed',
                response: 422,
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Planet not found'
                        ),
                        new OA\Property(
                            property: 'errors',
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'time',
                                    type: 'array',
                                    items: new OA\Items(
                                        type: 'string',
                                        example: 'The time field must be an integer.'
                                    )
                                )
                            ]
                        )
                    ]
                )
            )
        ]
    )]
    public function planetsAtTime(Request $request) {

        $request->validate([
            'time' => ['integer']
        ]);

        $time = ($request->input('time') ? Carbon::createFromTimeStamp($request->input('time')) : Carbon::now());

        $planets = Planet::with(['history' => function (Builder $q) use ($time) {
            $q->latest()->whereBetween(DB::raw($time->getTimestamp()), [DB::raw('valid_start'), DB::raw('last_valid')])->orWhereBetween('valid_start', [$time->getTimestamp(), $time->subMinutes(30)->getTimestamp()])->limit(1);
        }])->get();

        //error_log(print_r($planets));

        $history = collect($planets->pluck('history')->OneEntryArrayList());

        //error_log(print_r(DB::getQueryLog()));

        if (!$history->isEmpty()) {
            return response()->json($history, 200);
        } else {
            return response()->json([
                'error' => 'No valid entries could be found for this time',
                'code' => 404,
                'data' => $history,
                'planets' => $planets
            ], 404);
        }
    }

    #[OA\Get(
        path: '/api/planets/active',
        summary: 'Returns planets with active campaigns',
        tags: ['Planets'],
        responses: [
            new OA\Response(
                description: 'Planets with active campaigns',
                response: 200,
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        allOf: [
                            new OA\Schema(
                                ref: '#/components/schemas/Planet'
                            )
                        ],
                        properties: [
                            new OA\Property(
                                property: 'campaigns',
                                type: 'array',
                                items: new OA\Items(
                                    ref: '#/components/schemas/PlanetCampaign'
                                )
                            )
                        ]
                    )
                )
            )
        ]
    )]
    public function activeCampaigns() {

        $planets = Planet::whereHas('campaigns', function ($query) {
            $query->where('ended_at', null);
        })->get();

        $planets->load(['campaigns' => function ($query) {
            $query->where('ended_at', null)->limit(1);
        }]);

        //$planets;

        return response()->json($planets, 200);

    }

    public function playersGlobal(Request $request) {

        $data = $request->validate([
            "time" => ["nullable", "date"]
        ]);

        if (!$request->has('time')) {
            $time = Carbon::now();
            error_log($time);
        } else {
            $time = Carbon::parse($data['time']);
            error_log($time);
        }

        $planets = Planet::with(['history' => function (Builder $q) use ($time) {
            $q->latest()->where('created_at', '<', $time)->limit(1);
        }])->get();

        $players = $planets->pluck('history')->OneEntryArrayList()->sum('players');

        return response()->json([
            "count" => $players
        ], 200);

    }
}

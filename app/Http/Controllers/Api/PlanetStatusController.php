<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Planet;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PlanetStatusController extends Controller
{
    public function index(Request $request) {

        $request->validate([
            'index' => ['integer', 'required']
        ]);

        $planetIndex = $request->input('index');

        $planet = Planet::where('index', $planetIndex);

        if ($planet) {
            return response()->json($planet, 200);
        } else {
            return response()->json([
                'error' => 'Planet not found',
                'code' => 404,
            ], 404);
        }

    }

    public function planetsAtTime(Request $request) {

        $request->validate([
            'time' => ['date']
        ]);

        $time = Carbon::parse($request->input('time'));

        $planets = Planet::with(['history' => function (Builder $q) use ($time) {
            $q->latest()->where('created_at', '<', $time)->limit(1);
        }])->get();

        return response()->json($planets->pluck('history')->OneEntryArrayList(), 200);
    }

    public function latestPlanets(Request $request) {

        $planets = Planet::all();

        return response()->json($planets, 200);
    }
}

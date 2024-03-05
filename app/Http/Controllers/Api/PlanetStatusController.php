<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlanetStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanetStatusController extends Controller
{
    public function index(Request $request) {

        $request->validate([
            'planetIndex' => ['integer', 'required']
        ]);

        $planetIndex = $request->input('planetIndex');

        $warId = PlanetStatus::max('warId');
        $planet = PlanetStatus::latest()->where([['warId', $warId], ['index', $planetIndex]])->first();

        if ($planet) {
            return response()->json($planet, 200);
        } else {
            return response()->json([
                'error' => 'Planet not found',
                'code' => 404,
            ], 404);
        }

    }

    public function latestPlanets(Request $request) {

        $warId = PlanetStatus::max('warId');

        $planetsData = DB::select("SELECT b.`index`, `owner`, `health`, `regenPerSecond`, `players`, b.`created_at` FROM planet_statuses b JOIN (SELECT t.`index`, MAX(t.`created_at`) as created_at FROM planet_statuses t GROUP BY `index`) as indexes ON b.`index` = indexes.`index` AND b.created_at = indexes.`created_at`");

        $planets = PlanetStatus::hydrate($planetsData);

        //$planets = PlanetStatus::where('warId', $warId)->latest()->groupBy('index')->distinct('index')->get();

        if ($planets) {
            return response()->json($planets, 200);
        } else {
            return response()->json([
                'error' => 'Planets not found',
                'code' => 404,
            ], 404);
        }
    }
}

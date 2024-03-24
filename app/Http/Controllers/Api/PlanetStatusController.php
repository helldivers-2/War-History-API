<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlanetStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\error;

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

    public function planetsAtTime(Request $request) {

        $request->validate([
            'time' => ['date']
        ]);

        $planets = PlanetStatus::getAtTime(Carbon::parse($request->input('time')));

        return response()->json($planets, 200);
    }

    public function latestPlanets(Request $request) {


        #$planet_list = DB::table('planet_statuses')->select('index')->distinct()->get();

        // $planets = DB::table('planet_statuses')
        //     ->select('index', DB::raw('MAX(created_at) as max_created_at'))
        //     ->groupBy('index')
        //     ->get();

        // $planets = DB::table('planet_statuses')
        //     ->where('index', $planets->pluck('index'))
        //     ->where('created_at', $planets->pluck('created_at'))
        //     ->get();

        // $planets = PlanetStatus::hydrate($planets->all());

        $planetsData = DB::select("SELECT b.`index`, `owner`, `health`, `regenPerSecond`, `players`, b.`created_at` FROM planet_statuses b JOIN (SELECT t.`index`, MAX(t.`created_at`) as created_at FROM planet_statuses t GROUP BY `index`) as indexes ON b.`index` = indexes.`index` AND b.created_at = indexes.`created_at`");

        $planets = PlanetStatus::hydrate($planetsData);

        #$planets = new Collection();

        #$planets= PlanetStatus::whereIn('index', [1, 2, 3, 4])->latest()->distinct()->get();

        #foreach ($planet_list as $planet_index) {
            //$planets->push(PlanetStatus::whereIn('index', [1, 2, 3, 4])->latest()->get());
        #}

        return response()->json($planets, 200);
    }
}

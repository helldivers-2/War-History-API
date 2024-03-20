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

        $request->validate([
            'time' => ['nullable', 'date']
        ]);

        if ($request->has('time')) {

        }

        $planet_list = DB::table('planet_statuses')->select('index')->distinct()->get();

        $planets = new Collection();

        foreach ($planet_list as $planet_index) {
            $planets->push(PlanetStatus::where('index', $planet_index->index)->latest()->first());
        }

        return response()->json($planets, 200);
    }
}

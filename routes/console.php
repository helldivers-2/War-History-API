<?php

use App\Models\Planet;
use App\Models\PlanetHistory;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('fetch', function () {
    // Get current War ID
    $warIdRequest = Http::get('https://api.live.prod.thehelldiversgame.com/api/WarSeason/current/'); // TODO

    $currentWarId = 801; // TODO

    $planetRequest = Http::get('https://api.live.prod.thehelldiversgame.com/api/WarSeason/801/Status');

    if ($planetRequest->successful()) {
        $data = $planetRequest->json();

        foreach ($data['planetStatus'] as $planet) {

            $planet['warId'] = $currentWarId;
            $planet['regenPerSecond'] = round($planet['regenPerSecond'], 4);

            $planetModel = Planet::firstOrNew(['index' => $planet['index']]);
            $planetModel->fill($planet);
            $planetModel->save();

            $history = PlanetHistory::orderBy('updated_at', 'DESC')->where('index', $planet['index'])->first();

            if ($history && $history->makeHidden(['created_at', 'updated_at', 'id'])->toArray() == $planet) {
                $history->touch();
            } else {
                PlanetHistory::create($planet);
            }
        }

    }
});

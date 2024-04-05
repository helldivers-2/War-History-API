<?php

use App\Models\Planet;
use App\Models\PlanetCampaign;
use App\Models\PlanetHistory;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
    $warIdRequest = Http::get('https://api.live.prod.thehelldiversgame.com/api/WarSeason/current/WarId'); // TODO

    $currentWarId = $warIdRequest->json()['id'];

    $planetRequest = Http::withHeaders([
        'Accept-Language' => 'en-EN'
    ])->get("https://api.live.prod.thehelldiversgame.com/api/WarSeason/$currentWarId/Status");

    if ($planetRequest->successful()) {
        $data = $planetRequest->json();

        /* ----- Set the current PlanetStatus ----- */

        // Set default information
        foreach ($data['planetStatus'] as $planet) {

            $planet['warId'] = $currentWarId;
            $planet['regenPerSecond'] = round($planet['regenPerSecond'], 4);

            $planetModel = Planet::firstOrNew(['index' => $planet['index']]);
            $planetModel->fill($planet);
            $planetModel->save();

            $history = PlanetHistory::orderBy('updated_at', 'DESC')->where('index', $planet['index'])->first();

            if ($history && (
                $history->owner == $planet['owner'] &&
                $history->health == $planet['health'] &&
                round($history->regenPerSecond, 2) == round($planet['regenPerSecond'], 2) &&
                $history->players == $planet['players']
            )) {
                $history->touch();
            } else {
                PlanetHistory::create($planet)
            }
        }

        // Mark old campaigns as marked if they're not in the array
        $oldCampaigns = PlanetCampaign::where('ended_at', null);
        $newCampaignIds = collect($data['campaigns'])->pluck('id')->all();

        foreach ($oldCampaigns as $oldCampaign) {
            if (!in_array($oldCampaign->id, $newCampaignIds)) {
                $oldCampaign->ended_at = now();
            }
        }

        // Check for planet campaigns and add them
        foreach ($data['campaigns'] as $dataCampaign) {

            $planetCampaign = PlanetCampaign::where('id', $dataCampaign['id'])->first();

            // Check if the campaign is new or an old one
            if ($planetCampaign == null) {

                // Merge war id into the array and create a new PlanetCampaign with it
                $dataCampaign['warId'] = $currentWarId;

                PlanetCampaign::create($dataCampaign);

            }

        }

    }
});

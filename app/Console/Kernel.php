<?php

namespace App\Console;

use App\Models\Planet;
use App\Models\PlanetHistory;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {

        // $schedule->command('inspire')->hourly();
        $schedule->call(function() {

            // Get current War ID
            $warIdRequest = Http::get('https://api.live.prod.thehelldiversgame.com/api/WarSeason/current/'); // TODO

            $currentWarId = 801; // TODO

            $planetRequest = Http::get('https://api.live.prod.thehelldiversgame.com/api/WarSeason/801/Status');

            if ($planetRequest->successful()) {
                $data = $planetRequest->json();

                foreach ($data['planetStatus'] as $planet) {

                    $planet['warId'] = $currentWarId;

                    $planetModel = Planet::firstOrNew(['index' => $planet['index']]);
                    $planetModel->fill($planet);
                    $planetModel->save();

                    PlanetHistory::create($planet);
                }

            }

        })->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

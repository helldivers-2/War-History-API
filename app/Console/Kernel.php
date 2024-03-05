<?php

namespace App\Console;

use App\Models\PlanetStatus;
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
            $request = Http::get('https://api.live.prod.thehelldiversgame.com/api/WarSeason/801/Status');

            if ($request->successful()) {
                $data = $request->json();

                foreach ($data['planetStatus'] as $planet) {
                    PlanetStatus::create($planet);
                }

            }

        })->everyFifteenMinutes();
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

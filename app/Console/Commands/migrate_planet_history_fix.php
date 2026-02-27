<?php

namespace App\Console\Commands;

use App\Models\PlanetHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;

class migrate_planet_history_fix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate_planet_history_fix {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        if ($this->argument('id') == null)
        {

            PlanetHistory::where('id', '>=', 0)->chunk(100, function($models) {

                foreach($models as $model) {
                    $p = PlanetHistory::where('id', '>', $model->id)->where('index', $model->index)->orderBy('id', 'ASC')->first();
                    if ($p != null)
                    {
                        $model->last_valid = $p->created_at->subSeconds(1)->getTimestamp();
                        $this->info($p->id);
                    } else
                    {
                        $model->last_valid = 0;
                        $this->info('null');
                    }
                    $model->valid_start = $model->created_at->getTimestamp();
                    $model->save();
                    $this->info($model->id.' | '.$model->valid_start.' | '.$model->last_valid);
                }

            });

        } else if ($this->argument('id') > 0)
        {
            $model = PlanetHistory::find($this->argument('id'));
            $p = PlanetHistory::where('id', '>', $model->id)->where('index', $model->index)->orderBy('id', 'ASC')->first();
            if ($p != null)
                    {
                        $model->last_valid = $p->created_at->subSeconds(1)->getTimestamp();
                        $this->info($p->id);
                    } else
                    {
                        $model->last_valid = 0;
                        $this->info('null');
                    }
            $model->valid_start = $model->created_at->getTimestamp();
            $model->save();
            $this->info($model->id.' | '.$model->valid_start.' | '.$model->last_valid);
        } else if ($this->argument('id') == '+' && $this->argument('mode') != null)
        {


            PlanetHistory::where('id', '>=', $this->argument('mode'))->chunk(100, function($models) {

                foreach($models as $model) {
                    $p = PlanetHistory::where('id', '>', $model->id)->where('index', $model->index)->orderBy('id', 'ASC')->first();
                    if ($p != null)
                    {
                        $model->last_valid = $p->created_at->subSeconds(1)->getTimestamp();
                        $this->info($p->id);
                    } else
                    {
                        $model->last_valid = 0;
                        $this->info('null');
                    }
                    $model->valid_start = $model->created_at->getTimestamp();
                    $model->save();
                    $this->info($model->id.' | '.$model->valid_start.' | '.$model->last_valid);
                }
            });
        }
    }
}

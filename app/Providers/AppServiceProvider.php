<?php

namespace App\Providers;

use App\Faker\FakerImageProvider;
use Carbon\CarbonInterval;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Generator::class, function() {
            $faker = Factory::create();
            $faker->addProvider(new FakerImageProvider($faker));
            return $faker;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //checking models
        //Model::shouldBeStrict(app()->isProduction());
        Model::shouldBeStrict();
        if (!app()->isProduction()) {
            // if db query > 4 sec
            DB::whenQueryingForLongerThan(CarbonInterval::seconds(4), function (Connection $connection) {
                logger()->channel('telegram')->debug('whenQueryingForLongerThan: ' . $connection->totalQueryDuration());
            });
            //if every query > 100 ms
            DB::listen(function($query) {
                if ($query->time > 100) {
                    logger()->channel('telegram')->debug('whenQueryingForLongerThan: ' . $query->sql, $query->bindings);
                }
            });
            // if execution time of script > 4 sec
            $kernel = app(Kernel::class);
            $kernel->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                function () {
                    logger()
                        ->channel('telegram')
                        ->debug('whenRequestLifecycleIsLongerThan: ' . request()->url());
                }
            );
        }
    }
}

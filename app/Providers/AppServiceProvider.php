<?php

namespace App\Providers;

use App\Support\Testing\FakerImageProvider;
use Carbon\CarbonInterval;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
    public function boot(): void
    {
        //checking models
        Model::shouldBeStrict(); //Model::shouldBeStrict(app()->isProduction());
        if (app()->isProduction()) {
            //if every query > 100 ms
            DB::listen(function($query) {
                if ($query->time > 100) {
                    logger()->channel('telegram')->debug('query longer than 100ms: ' . $query->sql, $query->bindings);
                }
            });
            // if execution time of script > 4 sec
            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                function () {
                    logger()
                        ->channel('telegram')
                        ->debug('whenRequestLifecycleIsLongerThan: ' . request()->url());
                }
            );
        }
        //password validation
        Password::defaults(function () {
            return Password::min(8);
        });
    }
}

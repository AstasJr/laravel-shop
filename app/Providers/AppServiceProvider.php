<?php

namespace App\Providers;

use Carbon\CarbonInterval;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //N+1 error
        Model::preventLazyLoading(!app()->isProduction());
        //not set fillable property in model
        Model::preventSilentlyDiscardingAttributes(!app()->isProduction());
        // if db query > 500 ms
        DB::whenQueryingForLongerThan(500, function (Connection $connection) {
            logger()->channel('telegram')->debug('whenQueryingForLongerThan: ' . $connection->query()->toSql());
        });
        // if execution time of script > 4 seconds
        $kernel = app(Kernel::class);
        $kernel->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(0.01),
            function () {
                logger()
                    ->channel('telegram')
                    ->debug('whenRequestLifecycleIsLongerThan: ' . request()->url());
            }
        );
    }
}

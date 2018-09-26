<?php
/**
 * Created by PhpStorm.
 * User: Tinkerelle
 * Date: 4/16/2017
 * Time: 4:14 PM
 */

namespace App\Providers;


use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
         View::composer(
            'layouts.citizen', 'App\Http\ViewComposers\NotificationComposer'
        );
       /* // Using Closure based composers...
        View::composer('dashboard', function ($view) {
            //
        });*/
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
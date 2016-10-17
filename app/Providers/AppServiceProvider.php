<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\models\tagModel;
use App\services\tagService;
use View;
use Route;
use Illuminate\Support\Facades\Request;


class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //menu on header
        View::composer('layouts.client.header', function($view){
            $tagService = new tagService();
            $params = false;
            if(Route::current())
                $params = Route::current()->parameters();

            $view->with('menu_items', $tagService->getTagForClientMenu())->with('id_active', isset($params['id']) ? $params['id'] : 0);
        });

        //menu on footer
        View::composer('layouts.client.footer', function($view){
            $tagService = new tagService();
            $view->with('menu_items', $tagService->getTagForClientMenu());
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}

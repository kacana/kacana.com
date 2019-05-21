<?php namespace App\Providers;

use Carbon\Carbon;
use Cache;
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

            $expiresAt = Carbon::now()->addMinutes(300);
            $paramId = isset($params['id']) ? $params['id'] : 0;
            $key = '__main_menu_item__';
            $menuItem = Cache::get($key);
            if(!$menuItem) {
                $menuItem = $tagService->getTagForClientMenu();
                Cache::put($key, $menuItem, $expiresAt);
            }

            $view->with('menu_items', $menuItem)->with('id_active', $paramId);
        });

        //menu on footer
        View::composer('layouts.client.footer', function($view){
            $tagService = new tagService();
            $expiresAt = Carbon::now()->addMinutes(300);
            $key = '__main_menu_item__';
            $menuItem = Cache::get($key);
            if(!$menuItem) {
                $menuItem = $tagService->getTagForClientMenu();
                Cache::put($key, $menuItem, $expiresAt);
            }

            $view->with('menu_items', $menuItem);
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

<?php

namespace App\Providers;

use App\Models\Acceso;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
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
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $menus = auth()->user()->getMenu();
            $items = $menus->map(function ($menu) {
                return [
                    'text' => $menu->descripcion,
                    'icon'    => $menu->icono,
                    'submenu' => $menu->submenus->map(function ($submenu) {
                        return [
                            'text' => $submenu->descripcion,
                            'route'  => $submenu->ruta,
                            'icon' => $submenu->icono,
                            'target' => $submenu->target,
                        ];
                    })->toArray()
                ];
            });
            $event->menu->add(...$items);
        });
    }
}

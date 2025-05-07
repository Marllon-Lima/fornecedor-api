<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Registre os serviços de rotas para a aplicação.
     *
     * @return void
     */
    public function boot()
    {
        // Registrar as rotas da API
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        // Registrar as rotas da web
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    /**
     * Registre quaisquer serviços de aplicação.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

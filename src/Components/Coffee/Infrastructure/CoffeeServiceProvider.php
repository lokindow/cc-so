<?php

namespace Src\Components\Coffee\Infrastructure;

use Illuminate\Support\ServiceProvider;


class CoffeeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //IoC
        $this->app->bind('Src\Components\Coffee\Domain\Interfaces\BeansContainer', 'Src\Components\Coffee\Application\UseCases\Beans\BeansContainerUseCase');
        $this->app->bind('Src\Components\Coffee\Domain\Interfaces\EspressoMachineInterface', 'Src\Components\Coffee\Application\UseCases\EspressoMachine\EspressoMachineUseCase');
        $this->app->bind('Src\Components\Coffee\Domain\Interfaces\WaterContainer', 'Src\Components\Coffee\Application\UseCases\Water\WaterContainerUseCase');
        
        // Persistences
        $this->app->bind('Src\Components\Coffee\Domain\Interfaces\ICoffeeRepository', 'Src\Components\Coffee\Infrastructure\Persistences\CoffeeRepository');
     
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        include base_path('src/Components/Coffee/Infrastructure/routes.php');
    }
}

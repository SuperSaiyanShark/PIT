<?php

namespace Modules\Module4\app\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Module4\app\Providers\EventServiceProvider;
use Modules\Module4\app\Providers\RouteServiceProvider;
use Modules\Module4\app\Providers\AuthServiceProvider;

class Module4ServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Module4';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'module4';

    /**
     * Command classes to register.
     *
     * @var string[]
     */
    // protected array $commands = [];

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
        AuthServiceProvider::class,
    ];

    /**
     * Define module schedules.
     * 
     * @param $schedule
     */
    // protected function configureSchedules(Schedule $schedule): void
    // {
    //     $schedule->command('inspire')->hourly();     
    // }
}

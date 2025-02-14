<?php 

namespace Dev13\ModuleInstaller;

use Dev13\ModuleInstaller\Commands\InstallerCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Class ModuleInstallerServiceProvider
 * @package Dev13\ModuleInstaller
 */
class ModuleInstallerServiceProvider extends ServiceProvider {

    protected $packageName = 'module-installer';

    /**
     * A list of artisan commands for your package
     * 
     * @var array
     */
    protected $commands = [
        InstallerCommand::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->loadRoutesFrom(__DIR__.'/../routes/routes.php');

        // Register Views from your package
        //$this->loadViewsFrom(__DIR__.'/../views', $this->packageName);

        // Regiter migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Register translations
        //$this->loadTranslationsFrom(__DIR__.'/../lang', $this->packageName);
        //$this->publishes([
        //    __DIR__.'/../lang' => resource_path('lang/vendor/'. $this->packageName),
        //]);

        // Register your asset's publisher
        //$this->publishes([
        //    __DIR__.'/../assets' => public_path('vendor/'.$this->packageName),
        //], 'public');

        // Publish your seed's publisher
        $this->publishes([
            __DIR__.'/../database/seeds/' => base_path('/database/seeds')
        ], 'seeds');

        // Publish your config
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path($this->packageName.'.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php',
            $this->packageName
        );

    }

}

<?php

namespace Dev13\ModuleInstaller\Commands;

use Dev13\ModuleInstaller\Support\GeneratorSupport;
use Dev13\ModuleInstaller\Support\Path;
use Dev13\ModuleInstaller\Support\Stub;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module-installer:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * @var string injectable module
     */
    private $injectableModule;

    /**
     * @var string module
     */
    private $module;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->injectableModule =$this->ask('Injectable Module');
        $this->module = $this->ask('Module');

        $stub = with(new Stub('/migrations/Migration.stub', [
            'NAME'              => $this->module
        ]))->render();

        $message = with(new GeneratorSupport(
            Path::Init($this->injectableModule)->migration(). '/'. $this->createMigrationName($this->module) . '.php',
            $stub, $this->laravel
        ))->generate();

        return $message;
    }

    /**
     * @return string
     */
    private function createMigrationName($module)
    {
        $pieces = preg_split('/(?=[A-Z])/', $module, -1, PREG_SPLIT_NO_EMPTY);

        $string = '';
        foreach ($pieces as $i => $piece) {
            if ($i+1 < count($pieces)) {
                $string .= strtolower($piece) . '_';
            } else {
                $string .= Str::plural(strtolower($piece));
            }
        }

        return $string;
    }

}

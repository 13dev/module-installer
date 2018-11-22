<?php

namespace Dev13\ModuleInstaller\Commands;

use Dev13\ModuleInstaller\Support\GeneratorSupport;
use Dev13\ModuleInstaller\Support\Stub;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputArgument;

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
     * @var Module injectable module
     */
    private $injectableModule;

    /**
     * @var Module module
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
        $this->injectableModule = Module::findOrFail($this->argument('injectableModule'));
        $this->module = Module::findOrFail($this->argument('module'));

        $message = with(new GeneratorSupport(
            $this->module->getExtraPath('Migrations'). '/'. $this->createMigrationName(). '.php',
            with(new Stub('/migrations/Migration.stub', [
                'NAME'              => $this->module->getModelName()
            ]))->render()
        ))->generate();

        $this->info($message);
    }


    protected function getArguments()
    {
        return [
            ['injectableModule', InputArgument::REQUIRED, 'The name of model will recive \'upgrade\'.'],
            ['module', InputArgument::REQUIRED, 'The name of module will be used.'],
        ];
    }

    /**
     * @return string
     */
    private function createMigrationName()
    {
        $pieces = preg_split('/(?=[A-Z])/', $this->module->getLowerName(), -1, PREG_SPLIT_NO_EMPTY);

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

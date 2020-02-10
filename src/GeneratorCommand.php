<?php

namespace tdebatty\LaravelResourceGenerator;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * A command to
 */
class GeneratorCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'resource-generator:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a full source code for a Resource.';

    /** @var \Illuminate\Config\Repository */
    protected $config;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $files;


    /**
     *
     * @param \Illuminate\Config\Repository $config
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param \Illuminate\View\Factory $view
     */
    public function __construct(
        \Illuminate\Config\Repository $config,
        \Illuminate\Filesystem\Filesystem $files) {

        $this->config = $config;
        $this->files = $files;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $model = $this->argument('model');
        $icons = $this->option('icons');

        if (ucfirst($model) !== $model) {
            $this->error("Model parameter must be CamelCase");
            return;
        }

        $model_lower = strtolower($model);
        $model_plural = Str::plural($model_lower);
        $controller_name = $model . "Controller";

        $this->info("Generate migration and model...");
        Artisan::call('make:model', [
            "--migration" => true,
            "--resource" => true,
            "name" => $model]);

        $this->info("Generate routes: routes/web.php");
        $this->files->append("routes/web.php", "\nRoute::resource('app/$model_plural', '$controller_name');");

        $this->info("Generate views: resources/views/" . $model_lower);
        $this->files->makeDirectory("resources/views/" . $model_lower);


        $resolver = new EngineResolver();
        $resolver->register('php', function () {
            return new PhpEngine();
        });

        $app = app();
        $finder = new FileViewFinder($app['files'], [__DIR__ . '/templates']);
        $factory = new Factory($resolver, $finder, $app['events']);
        $factory->addExtension('php', 'php');
        $index = $factory->make('index')
            ->with('Model', $model)
            ->with("icons", $this->icons($icons))
            ->render();
        $this->files->put("resources/views/" . $model_lower . "/index.blade.php", $index);

        $edit = $factory->make('edit')
            ->with('Model', $model)
            ->with("icons", $this->icons($icons))
            ->render();
        $this->files->put("resources/views/" . $model_lower . "/edit.blade.php", $edit);

        $show = $factory->make('show')
            ->with('Model', $model)
            ->with("icons", $this->icons($icons))
            ->render();
        $this->files->put("resources/views/" . $model_lower . "/show.blade.php", $show);

        $this->info("Generate controller: app/Http/Controllers/" . $model . "Controller.php");
        $controller = $factory->make('controller')
            ->with('Model', $model)
            ->render();
        $this->files->put("app/Http/Controllers/" . $model . "Controller.php", $controller);

        $this->info("Done!");
        $this->info("You may now fill the migration file");
        $this->info("And then run php artisan migrate");
        $this->info("Your resources will be available at http://127.0.0.1:8000/app/$model_plural");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'The model name (CamelCase)'],
        ];
    }
    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['icons', "i", InputOption::VALUE_OPTIONAL, 'The icon set to use (none, fa, fa4)', "none"]
       ];
    }

    public function icons($set) {
        switch ($set) {
            case "fa":
                return [
                    "new" => '<i class="fas fa-plus-circle"></i>',
                    "edit" => '<i class="fas fa-edit"></i>',
                    "show" => '<i class="fas fa-search"></i>',
                    "delete" => '<i class="fas fa-times-circle"></i>',
                    "ok" => '<i class="fas fa-check"></i>'
                ];

            case "fa4":
                return [
                    "new" => '<i class="fa fa-plus-circle" aria-hidden="true"></i>',
                    "edit" => '<i class="fa fa-pencil" aria-hidden="true"></i>',
                    "show" => '<i class="fa fa-search" aria-hidden="true"></i>',
                    "delete" => '<i class="fa fa-times-circle" aria-hidden="true"></i>',
                    "ok" => '<i class="fa fa-check" aria-hidden="true"></i>'
                ];

            default:
                return [
                    "new" => "",
                    "edit" => "",
                    "show" => "",
                    "delete" => "",
                    "ok" => ""
                ];
        }
    }
}

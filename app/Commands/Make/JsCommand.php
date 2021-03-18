<?php

namespace App\Commands\Make;

use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Str;

class JsCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:js
                            {name? : The name of the JS file to create}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a new JS file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name') ?: $this->ask('What is the body class for this file?');
        $name = Str::camel($name);
        $body_class = Str::kebab($name);

        $this->info("Creating new js file: {$name}");

        // Create JS File
        $_js_file = file_get_contents(base_path('stubs/script.js.stub'));

        file_put_contents(config('paths.js') . "/{$name}.js", $_js_file);

        $this->info("Import: import {$name} from './views/{$name}'");
        $this->info("Router: .on('{$body_class}', {$name})");
    }
}

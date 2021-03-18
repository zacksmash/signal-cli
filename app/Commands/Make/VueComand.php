<?php

namespace App\Commands\Make;

use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Str;

class VueComand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:vue
                            {name? : The name of the Vue component}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a new Vue component';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name') ?: $this->ask('What is the name of the Vue component?');
        $name = Str::camel($name);
        $studly_name = Str::studly($name);

        $this->info("Creating new Vue component: {$studly_name}");

        // Create New Vue File
        file_put_contents(
            config('paths.vue') . "/{$studly_name}.vue",
            file_get_contents(base_path('stubs/vue.js.stub'))
        );
    }
}

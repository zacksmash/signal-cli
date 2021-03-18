<?php

namespace App\Commands\Make;

use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Str;

class LayoutCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:layout
                            {name? : The name of the layout file to create}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a new ACF layout file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name') ?: $this->ask('What is the name of the layout?');
        $name = Str::camel($name);
        $kebab_name = Str::kebab($name);

        $this->info("Creating new layout file: {$kebab_name}");

        // Create Blade File
        file_put_contents(
            config('paths.layout') . "/{$kebab_name}.blade.php",
            ''
        );

        // Create SCSS File
        file_put_contents(
            config('paths.scss.layout') . "/_{$kebab_name}.scss",
            ''
        );

        // Import SCSS File
        $import = "@import '../../layouts/{$kebab_name}';";
        file_put_contents(config('paths.scss.import') . '/_layouts.scss', $import . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

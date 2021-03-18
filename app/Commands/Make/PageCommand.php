<?php

namespace App\Commands\Make;

use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Str;

class PageCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:page
                            {name? : The name of the page template}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Scaffold the assets for a new page template';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name') ?: $this->ask('What is the name of the page?');
        $name = Str::camel($name);
        $file_name = Str::kebab($name);
        $page_name = Str::title(str_replace('-', ' ', $file_name));

        $this->info("Creating page template: {$page_name}");

        // Create Template File
        $_page = str_replace(
            '{pageName}',
            $page_name,
            file_get_contents((base_path('stubs/page.blade.stub')))
        );

        file_put_contents(
            config('paths.page') . "/page-{$file_name}.blade.php",
            $_page
        );

        // Create SCSS File
        $_scss_file = str_replace(
            '{pageName}',
            $file_name,
            file_get_contents(base_path('stubs/page.scss.stub'))
        );

        file_put_contents(
            config('paths.scss.page') . "/_{$file_name}.scss",
            $_scss_file
        );

        // Import SCSS File
        $import = "@import '../../views/{$file_name}';";
        file_put_contents(config('paths.scss.import') . '/_views.scss', $import . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

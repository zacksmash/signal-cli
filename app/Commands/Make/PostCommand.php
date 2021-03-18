<?php

namespace App\Commands\Make;

use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Str;

class PostCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:post
                            {name? : The name of the post type}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Scaffold the assets for a new custom post type';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name') ?: $this->ask('What is the name of the post type?');
        $name = Str::camel($name);
        $snake_name = Str::snake($name);
        $kebab_name = Str::kebab($name);

        $this->info("Creating new post archive/single template: {$snake_name}");

        // Create Post Archive File
        file_put_contents(
            config('paths.post') . "/archive-{$snake_name}.blade.php",
            file_get_contents(base_path('stubs/post-archive.blade.stub'))
        );

        // Create Post Single File
        file_put_contents(
            config('paths.post') . "/single-{$snake_name}.blade.php",
            file_get_contents(base_path('stubs/post-single.blade.stub'))
        );

        // Create SCSS File
        $_scss_file = str_replace(
            '{postType}',
            $kebab_name,
            file_get_contents(base_path('stubs/post.scss.stub'))
        );

        file_put_contents(
            config('paths.scss.post') . "/_{$kebab_name}.scss",
            $_scss_file
        );

        // Import SCSS File
        $import = "@import '../../views/{$kebab_name}';";
        file_put_contents(config('paths.scss.import') . '/_views.scss', $import . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}

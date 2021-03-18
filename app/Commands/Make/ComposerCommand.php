<?php

namespace App\Commands\Make;

use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Str;

class ComposerCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:composer
                            {name? : The name of the view composer}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a new View Composer';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name') ?: $this->ask('What is the name of the view composer?');
        $name = Str::camel($name);
        $class_name = Str::studly($name);

        $this->info("Creating new view composer: {$class_name}");

        $_composer = str_replace(
            '{className}',
            $class_name,
            file_get_contents(base_path('stubs/composer.php.stub'))
        );

        file_put_contents(config('paths.composer') . "/{$class_name}.php", $_composer);
    }
}

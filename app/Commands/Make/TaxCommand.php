<?php

namespace App\Commands\Make;

use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Str;

class TaxCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:tax
                            {name? : The name of the taxonomy to create}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Scaffold the assets for a new taxonomy';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name') ?: $this->ask('What is the name of the taxonomy?');
        $name = Str::camel($name);
        $snake_name = Str::snake($name);

        $this->info("Creating new taxonomy template: {$snake_name}");

        // Create New Taxonomy Template
        file_put_contents(
            config('paths.tax') . "/taxonomy-{$snake_name}.blade.php",
            file_get_contents(base_path('stubs/tax.blade.stub'))
        );
    }
}

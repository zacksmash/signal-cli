<?php

namespace App\Commands;

use Carbon\Carbon;
use LaravelZero\Framework\Commands\Command;

class PushCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'push';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Push the changes to the repository';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Pushing changes...');

        // Push Site Code
        $build_date = Carbon::now()
            ->setTimezone('America/Denver')
            ->format('Y-m-d H:i:s');

        shell_exec('npm run prod;
        git add . -A;
        git commit -m "Build ' . $build_date . ' ";
        git push;');
    }
}

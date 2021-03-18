<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class DeployCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'deploy';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Deploy latest build to Signal Theme';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Deploying the executable build to the Signal Theme');

        shell_exec('cp builds/signal ' . env('SIGNAL_THEME'));
    }
}

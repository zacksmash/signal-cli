<?php

namespace App\Commands\Make;

use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class WooCommand extends Command {
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:woo';
    
    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Scaffold out the assets for a WooCommerce install';
    
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        
        // Ask to install WooCommerce plugin, defaults to "yes"
        $install_plugin = $this->confirm('Also install the WooCommerce plugin?', true);
        
        $this->info('Installing roots/sage-woocommerce composer package');
        
        // Install sage-woocommerce package
        shell_exec('composer require roots/sage-woocommerce --quiet');
        
        // Optionally install woocommerce plugin
        if ($install_plugin) {
            
            $this->info('Installing the WooCommerce plugin');
            
            shell_exec('wp plugin install woocommerce --quiet && wp plugin activate woocommerce --quiet');
        }
        
        // Create woocommerce template override directory
        if (!File::exists(config('paths.woocommerce'))) {
            
            $this->info('Creating woocommerce directory for template overrides');
            
            File::makeDirectory(config('paths.woocommerce'));
        }
    }
}

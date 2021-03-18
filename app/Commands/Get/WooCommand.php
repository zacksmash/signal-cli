<?php

namespace App\Commands\Get;

use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class WooCommand extends Command {
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'get:woo';
    
    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Add a WooCommerce blade template';
    
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        
        // Get available WooCommerce blade templates
        $stubs = File::files(base_path('stubs/woocommerce'));
        $file_names = [];
        
        // Build up array as ["template-name.blade.php" => "template-name"]
        foreach ($stubs as $stub) {
            $key = $stub->getFilename();
            $value = str_replace('.blade.stub', '', $key);
            
            $file_names[$key] = $value;
        }
        
        // Get selected template from the menu
        $selection = $this->menu('Available WooCommerce Blade Templates', $file_names)
                          ->setForegroundColour('cyan')
                          ->setBackgroundColour('default')
                          ->setExitButtonText('cancel')
                          ->open();
        
        if ($selection) {
            $stub_template = File::get(base_path("stubs/woocommerce/{$selection}"));
            $blade_template = str_replace('.stub', '.php', $selection);
            
            // Check if blade template already exists
            if (File::exists(config('paths.woocommerce') . "/{$blade_template}")) {
                $this->warn('Template already exists in your woocommerce directory!');
                $this->warn('Continuing will override your current file.');
    
                // Confirm that you want to replace the current file
                $replace = $this->confirm('Replace current template with a new one?');
                
                // Exit early if answer is No
                if (!$replace)
                    return false;
                
                // Double check if we should delete the current file
                $replace = $this->confirm('Are you sure? This will delete your current template!');
                
                // Exit early if answer is No
                if (!$replace)
                    return false;
            }
            
            // Create views/woocommerce/ directory if it doesn't exists
            if (!File::exists(config('paths.woocommerce')))
                File::makeDirectory(config('paths.woocommerce'));
            
            // Add new template
            File::put(config('paths.woocommerce') . "/{$blade_template}", $stub_template);
            
            $this->info("Added new template: \"" . config('paths.woocommerce') . "/{$blade_template}\"");
        }
    }
}

<?php

namespace App\Commands\Get;

use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class ComponentCommand extends Command {
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'get:component';
    
    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Add an exisitng blade component';
    
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        
        // Get available blade components
        $stubs = File::files(base_path('stubs/components'));
        $file_names = [];
        
        // Build up array as ["component-name.blade.php" => "component-name"]
        foreach ($stubs as $stub) {
            $key = $stub->getFilename();
            $value = str_replace('.blade.stub', '', $key);
            
            $file_names[$key] = $value;
        }
        
        // Get selected template from the menu
        $selection = $this->menu('Available Blade Components', $file_names)
                          ->setForegroundColour('cyan')
                          ->setBackgroundColour('default')
                          ->setExitButtonText('cancel')
                          ->open();
        
        if ($selection) {
            $stub_template = File::get(base_path("stubs/components/{$selection}"));
            $blade_template = str_replace('.stub', '.php', $selection);
            
            // Check if blade component already exists
            if (File::exists(config('paths.component') . "/{$blade_template}")) {
                $this->warn('Component already exists!');
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
            
            // Create views/components/ directory if it doesn't exists
            if (!File::exists(config('paths.component')))
                File::makeDirectory(config('paths.component'));
            
            // Add new components
            File::put(config('paths.component') . "/{$blade_template}", $stub_template);
            
            $this->info("Added new component: \"" . config('paths.component') . "/{$blade_template}\"");
        }
    }
}

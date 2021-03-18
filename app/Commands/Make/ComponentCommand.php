<?php

namespace App\Commands\Make;

use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Str;

class ComponentCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:component
                            {name? : The name of the component}
                            {--class : Include a Component Class}
                            {--props= : Comma separated list of properties, default value separated by a colon}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a new Blade component';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name') ?: $this->ask('What is the name of the component?');
        $name = Str::camel($name);
        $kebab_name = Str::kebab($name);

        $this->info("Creating new component: {$kebab_name}");

        // Create Blade File
        file_put_contents(
            config('paths.component') . "/{$kebab_name}.blade.php",
            ''
        );

        // Create SCSS File
        file_put_contents(
            config('paths.scss.component') . "/_{$kebab_name}.scss",
            ''
        );

        // Import SCSS File
        $import = "@import '../../components/{$kebab_name}';";
        file_put_contents(config('paths.scss.import') . '/_components.scss', $import . PHP_EOL, FILE_APPEND | LOCK_EX);

        // Create Component Class File if --class was passed
        if ($this->option('class')) {
            $class_name = Str::studly($name);

            $props = $this->option('props') ?: $this->ask('What properties does this component need?');

            if ($props) {
                $props = explode(',', $props);
                $props_init = '';
                $props_docblock = "\n";
                $props_constructor = [];
                $props_assign = '';
                $props_index = 1;
                $props_count = count($props);

                foreach ($props as $prop) {
                    $is_last = ($props_index == $props_count);

                    // Get Prop Values
                    $prop = explode(':', $prop);

                    // Initialize class properties
                    $props_init .= "
\t/**
\t * {$name} {$prop[0]}.
\t *
\t * @var string
\t */
\tpublic \${$prop[0]};
                    ";

                    if (!$is_last) {
                        $props_init .= "\n";
                    }

                    $prop_value = null;
                    $prop_type = null;

                    if (count($prop) === 1) {
                        $props_constructor[] = "\${$prop[0]} = ''";
                    } else {
                        if ($prop[1] == 'true' || $prop[1] == 'false') {
                            $prop_value = $prop[1];
                            $prop_type = 'boolean';
                        } elseif (is_numeric($prop[1])) {
                            $prop_value = $prop[1];
                            $prop_type = 'integer';
                        } elseif (is_string($prop[1])) {
                            $prop_value = '"' . $prop[1] . '"';
                            $prop_type = 'string';
                        } else {
                            $prop_value = '"' . $prop[1] . '"';
                            $prop_type = 'mixed';
                        }

                        $props_constructor[] = "\${$prop[0]} = {$prop_value}";
                    }

                    $prop_type = count($prop) > 1 ? $prop_type : 'mixed';

                    $props_docblock .= "\t * @param " . $prop_type . " \${$prop[0]}";

                    if (!$is_last) {
                        $props_docblock .= "\n";
                    }

                    $props_assign .= "\t\t\$this->{$prop[0]} = \${$prop[0]};";

                    if (!$is_last) {
                        $props_assign .= "\n";
                    }

                    $props_index++;
                }

                $props_constructor = implode(', ', $props_constructor);
            }

            $_component = str_replace(
                ['{className}', '{componentName}', '{propsInit}', '{propsDocblock}', '{propsConstructor}', '{propsAssign}'],
                [$class_name, Str::kebab($class_name), $props_init, $props_docblock, $props_constructor, $props_assign],
                file_get_contents(base_path('stubs/component.php.stub'))
            );

            file_put_contents(config('paths.component_class') . "/{$class_name}.php", $_component);
        }
    }

    public function creatProps()
    {
    }
}

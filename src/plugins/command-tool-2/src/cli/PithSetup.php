<?php

/**
 * Pith Setup
 * ----------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Properties with underscores are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Short method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Short PHP predefined variable names like $argv are ok.
 */

declare(strict_types=1);

namespace Pith\Framework\Plugin\CommandTool2;

use Exception;
use IKM\CLI\CommandLineFormatter;
use IKM\CLI\CommandLineWriter;

/**
 * Class PithSetup
 */
class PithSetup
{
    public function __construct()
    {
        // Do nothing.
    }

    public function run()
    {
        $format = new CommandLineFormatter();

        $is_ready = true;

        fwrite(STDOUT, "\n" . '──────────────────────────────────────────' . "\n");

        // VendorNamespace\ProjectNamespace

        fwrite(STDOUT, "\n");
        $output = 'Add a namespace to use for this project.' . "\n"
            . "\n"
            . '████ The normal format to use: ' . $format->bg_dark_black . $format->fg_dark_yellow . $format->italic . '{vendor namespace here} ' . $format->reset . $format->bg_dark_black . $format->fg_bright_yellow . '\\' . $format->fg_dark_yellow . $format->italic . ' {project namespace here}' . $format->reset . "\n";
        fwrite(STDOUT, $output);

        $output = '████ Example 1: ' . $format->bg_dark_black . $format->fg_bright_yellow . 'ExampleCompanyStudios\\OurAwesomeWebProject' . $format->reset . "\n";
        fwrite(STDOUT, $output);

        $output = '████ Example 2: ' . $format->bg_dark_black . $format->fg_bright_yellow . 'JohnDoe\\MyCoolProject' . $format->reset . "\n";
        fwrite(STDOUT, $output);


        $project_full_namespace = '';
        if($is_ready){
            fwrite(STDOUT, "\n");
            $output = $format->reset . 'Project Namespace: ';
            do{
                $input = readline($output);
            } while(empty($input));
        }
        $project_full_namespace = $input;
        $migration_namespace = $project_full_namespace . '\\Migration';

        fwrite(STDOUT, $format->reset . "\n");

        fwrite(STDOUT, "\n" . '──────────────────────────────────────────' . "\n");

        fwrite(STDOUT, 'Summary:' . "\n\n");

        fwrite(STDOUT, 'Project Namespace: ' . $format->fg_bright_cyan . $project_full_namespace . $format->reset . "\n");
        fwrite(STDOUT, 'Migration Namespace: ' . $format->fg_bright_cyan . $migration_namespace . $format->reset . "\n");

        // Ask to run set up
        $setup_new_pith_project = false;
        if($is_ready){
            fwrite(STDOUT, "\n");
            $output = 'Create Pith project? (yes/no): ';

            do{
                $input = readline($output);
            } while(empty($input));
        }
        $setup_new_pith_project = $input === 'yes';

        if($setup_new_pith_project) {
            $output = "\n" . 'Setting up new Pith Framework project.'. "\n";
            fwrite(STDOUT, $output);

            // Cache
            $this->existFolder('./cache');
            $this->existFolder('./cache/latte-cache');
            $this->existMdFile('./cache/latte-cache/latte-cache.md', 'Latte will put the Latte cache files in this folder.');
            $this->existFolder('./cache/touchstones');
            $this->existMdFile('./cache/touchstones/about-touchstone-folder.md', 'The Touchstone Utility will put empty files in this folder.');
            $this->existFolder('./cache/touchstones/impression-system');
            $this->existMdFile('./cache/touchstones/impression-system/about-impression-touchstone-folder.md', 'The impression system will put empty files in this folder.');
            $this->existFolder('./cache/touchstones/janitor');
            $this->existMdFile('./cache/touchstones/janitor/about-janitor-touchstone-folder.md', 'The Janitor system will put empty files in this folder.');

            // Logs
            $this->existFolder('./logs');
            $this->existFolder('./logs/impression-logs');
            $this->existMdFile('./logs/impression-logs/about-impression-logs.md', 'The impression logs will go here.');
            $this->existFolder('./logs/php-error-logs');
            $this->existMdFile('./logs/php-error-logs/about-php-error-logs.md', 'The PHP error log files will go in this folder.');
            $this->existFolder('./logs/task-logs');
            $this->existMdFile('./logs/task-logs/about-task-logs.md', 'The task logs will go in this folder.');
            $this->existFolder('./logs/task-output-logs');
            $this->existMdFile('./logs/task-output-logs/about-task-output-logs.md', 'The task output logs will go in this folder.');

            // Migrations
            $this->existFolder('./migrations');
            $this->existMdFile('./migrations/about-migrations.md', 'Migrations will go here.');

            // Run
            $this->existFolder('./run');
            $this->existFolder('./run/public-local');
            $this->copyFileIfNotExists('./vendor/pith/framework/run/public-local/about-how-to-run-on-local.md', './run/public-local/about-how-to-run-on-local.md');
            $this->copyFileIfNotExists('./vendor/pith/framework/run/public-local/favicon.png', './run/public-local/favicon.png');
            $this->copyFileIfNotExists('./vendor/pith/framework/run/public-local/index.php', './run/public-local/index.php');
            $this->copyFileIfNotExists('./vendor/pith/framework/run/public-local/serve.php', './run/public-local/serve.php');
            $this->existFolder('./run/public-web');
            $this->copyFileIfNotExists('./vendor/pith/framework/run/public-web/.htaccess', './run/public-web/.htaccess');
            $this->copyFileIfNotExists('./vendor/pith/framework/run/public-web/about-how-to-run-on-web-host.md', './run/public-web/about-how-to-run-on-web-host.md');
            $this->copyFileIfNotExists('./vendor/pith/framework/run/public-web/favicon.png', './run/public-web/favicon.png');
            $this->copyFileIfNotExists('./vendor/pith/framework/run/public-web/index.php', './run/public-web/index.php');

            // Src
            $this->existFolder('./src');

            // Git
            $this->copyFileIfNotExists('./vendor/pith/framework/.gitignore', './.gitignore');

            // Env
            $this->copyFileIfNotExists('./vendor/pith/framework/env.dist.php', './env.dist.php');
            $this->copyFileIfNotExists('./vendor/pith/framework/env.dist.php', './env.php');

            // Front Controller
            $this->copyFileIfNotExists('./vendor/pith/framework/front-controller.php', './front-controller.php');

            // Migrations tool
            $this->copyFileIfNotExists('./vendor/pith/framework/mig', './mig');
            $this->copyFileIfNotExists('./vendor/pith/framework/migration-config.php', './migration-config.php');

            // Pith command tool
            $this->copyFileIfNotExists('./vendor/pith/framework/pith', './pith');

            // Task tool
            $this->copyFileIfNotExists('./vendor/pith/framework/task', './task');
        }
    }

    public function existFolder(string $folder_path){
        $format = new CommandLineFormatter();

        $output = '    - Ensure that the ' . $folder_path . ' folder exists.'. "\n";
        fwrite(STDOUT, $output);


        // Get if the folder exists
        $has_folder = file_exists($folder_path) && is_dir($folder_path);
        if($has_folder){
            $output = $format->fg_bright_green . '        ✔ The '. $folder_path .' folder exists.' . $format->reset . "\n";
            fwrite(STDOUT, $output);
        }
        else{
            $output = $format->fg_bright_red . '        ✘ ' . $format->fg_bright_yellow . 'The ' . $folder_path . ' folder does not exist.' . $format->reset . "\n";
            fwrite(STDOUT, $output);

            $output = $format->fg_bright_yellow . '        ▭ ' . $format->reset . 'Making the ' . $folder_path . ' folder.' . "\n";
            fwrite(STDOUT, $output);

            mkdir($folder_path);

            // Get if the folder exists
            $has_folder = file_exists($folder_path) && is_dir($folder_path);

            if($has_folder){
                $output = $format->fg_bright_green . '        ✹ Created the '. $folder_path .' folder.' . $format->reset . "\n";
                fwrite(STDOUT, $output);
            }
            else{
                $output = $format->fg_bright_red . '        ✘ Failed to create the '. $folder_path .' folder.' . $format->reset . "\n";
                fwrite(STDOUT, $output);
            }
        }
    }

    public function existMdFile(string $file_path, string $message)
    {
        $format = new CommandLineFormatter();

        $output = '    - Add md file ' . $file_path . ' if needed.' . "\n";
        fwrite(STDOUT, $output);

        // Get if the file exists
        $has_file = file_exists($file_path);

        if($has_file){
            // Display file exists
            $output = $format->fg_bright_green . '        ✔ The '. $file_path .' file exists.' . $format->reset . "\n";
            fwrite(STDOUT, $output);
        }
        else{
            // Display file does not exist
            $output = $format->fg_bright_red . '        ✘ ' . $format->fg_bright_yellow . 'The ' . $file_path . ' file does not exist.' . $format->reset . "\n";
            fwrite(STDOUT, $output);

            // Display that we will create the file
            $output = $format->fg_bright_yellow . '        ▭ ' . $format->reset . 'Writing the ' . $file_path . ' file.' . "\n";
            fwrite(STDOUT, $output);

            // Write new file
            $file = @fopen($file_path,'w');
            fwrite($file,$message);
            fclose($file);

            // Get if the file exists
            $has_file = file_exists($file_path);

            if($has_file){
                $output = $format->fg_bright_green . '        ✹ Created the '. $file_path .' file.' . $format->reset . "\n";
                fwrite(STDOUT, $output);
            }
            else{
                $output = $format->fg_bright_red . '        ✘ Failed to create the '. $file_path .' file.' . $format->reset . "\n";
                fwrite(STDOUT, $output);
            }
        }
    }

    public function copyFileIfNotExists(string $vendor_file_path, string $destination_file_path){
        $format = new CommandLineFormatter();

        $output = '    - Add file ' . $destination_file_path . ' if it does not already exist.' . "\n";
        fwrite(STDOUT, $output);

        // Get if the file exists
        $has_file = file_exists($destination_file_path);

        if($has_file){
            // Display file exists
            $output = $format->fg_bright_green . '        ✔ The '. $destination_file_path .' file already exists.' . $format->reset . "\n";
            fwrite(STDOUT, $output);
        }
        else{
            // Display file does not exist
            $output = $format->fg_bright_red . '        ✘ ' . $format->fg_bright_yellow . 'The ' . $destination_file_path . ' file does not exist.' . $format->reset . "\n";
            fwrite(STDOUT, $output);

            // Display that we will create the file
            $output = $format->fg_bright_yellow . '        ▭ ' . $format->reset . 'Getting the ' . $destination_file_path . ' file from the vendor/ folder.' . "\n";
            fwrite(STDOUT, $output);

            // Add the new file
            $did_copy = @copy($vendor_file_path, $destination_file_path);

            if($did_copy){
                $output = $format->fg_bright_green . '        ✹ Added the '. $destination_file_path .' file.' . $format->reset . "\n";
                fwrite(STDOUT, $output);
            }
            else{
                $output = $format->fg_bright_red . '        ✘ Failed to add the '. $destination_file_path .' file.' . $format->reset . "\n";
                fwrite(STDOUT, $output);
            }
        }
    }
}
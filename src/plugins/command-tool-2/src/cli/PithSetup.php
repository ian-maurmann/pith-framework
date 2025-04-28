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

            $output = $format->fg_bright_yellow . '        ✹ ' . $format->reset . 'Making the ' . $folder_path . ' folder.' . "\n";
            fwrite(STDOUT, $output);

            mkdir($folder_path);

            // Get if the folder exists
            $has_folder = file_exists($folder_path) && is_dir($folder_path);

            if($has_folder){
                $output = $format->fg_bright_green . '        ✔ Created the '. $folder_path .' folder.' . $format->reset . "\n";
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
            $output = $format->fg_bright_yellow . '        ✹ ' . $format->reset . 'Writing the ' . $file_path . ' file.' . "\n";
            fwrite(STDOUT, $output);

            // Write new file
            $file = @fopen($file_path,'w');
            fwrite($file,$message);
            fclose($file);

            // Get if the file exists
            $has_file = file_exists($file_path);

            if($has_file){
                $output = $format->fg_bright_green . '        ✔ Created the '. $file_path .' file.' . $format->reset . "\n";
                fwrite(STDOUT, $output);
            }
            else{
                $output = $format->fg_bright_red . '        ✘ Failed to create the '. $file_path .' file.' . $format->reset . "\n";
                fwrite(STDOUT, $output);
            }
        }
    }
}
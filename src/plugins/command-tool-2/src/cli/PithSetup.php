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

        fwrite(STDOUT, '──────────────────────────────────────────' . "\n");

        $output = 'Add a main title for this project.' . "\n"
            . "\n"
            . '████ The normal format to use is the title-case name of your project with spaces.' . "\n";
        fwrite(STDOUT, $output);

        $output = '████ Example: ' . $format->bg_dark_black . $format->fg_bright_yellow . 'My Awesome Project' . $format->reset . "\n";
        fwrite(STDOUT, $output);

        $project_main_title = '';
        if($is_ready){
            fwrite(STDOUT, "\n");
            $output = $format->reset . 'Project Main Title: ';
            do{
                $input = readline($output);
            } while(empty($input));
        }
        $project_main_title = $input;

        fwrite(STDOUT, '──────────────────────────────────────────' . "\n");

        $output = 'Add a name to use for this project in PHP Class Naming.' . "\n"
            . "\n"
            . '████ The normal format to use is the PascalCase name of your project,' . "\n"
            . '████ with the first letter of each word capitalized, no spaces.' . "\n";
        fwrite(STDOUT, $output);

        $output = '████ Example: ' . $format->bg_dark_black . $format->fg_bright_yellow . 'MyAwesomeProject' . $format->reset . "\n";
        fwrite(STDOUT, $output);

        $project_name_in_php = '';
        if($is_ready){
            fwrite(STDOUT, "\n");
            $output = $format->reset . 'Project Name to use in PHP: ';
            do{
                $input = readline($output);
            } while(empty($input));
        }
        $project_name_in_php = $input;
        $pack_name = $project_name_in_php . 'Pack';
        $project_namespace_string = $this->doubleBackslashAndStartsWithDoubleBackslash($project_full_namespace);
        $pack_namespace_string = $project_namespace_string . '\\\\' . $pack_name;

        fwrite(STDOUT, '──────────────────────────────────────────' . "\n");

        $output = 'Add a name to use for this project in JS.' . "\n"
            . "\n"
            . '████ The normal format to use is the PascalCase name of your project,' . "\n"
            . '████ with the first letter of each word capitalized, no spaces.' . "\n";
        fwrite(STDOUT, $output);

        $output = '████ Example: ' . $format->bg_dark_black . $format->fg_bright_yellow . 'MyAwesomeProject' . $format->reset . "\n";
        fwrite(STDOUT, $output);

        $project_name_in_script = '';
        if($is_ready){
            fwrite(STDOUT, "\n");
            $output = $format->reset . 'Project Name to use in JS: ';
            do{
                $input = readline($output);
            } while(empty($input));
        }
        $project_name_in_script = $input;


        fwrite(STDOUT, '──────────────────────────────────────────' . "\n");

        $output = 'Add a name to use for this project in CSS.' . "\n"
            . "\n"
            . '████ The normal format to use is the kebab-case name of your project,' . "\n"
            . '████ lowercase, with hyphens between words, no spaces.' . "\n";
        fwrite(STDOUT, $output);

        $output = '████ Example: ' . $format->bg_dark_black . $format->fg_bright_yellow . 'my-awesome-project' . $format->reset . "\n";
        fwrite(STDOUT, $output);

        $project_name_in_style = '';
        if($is_ready){
            fwrite(STDOUT, "\n");
            $output = $format->reset . 'Project Name to use in CSS: ';
            do{
                $input = readline($output);
            } while(empty($input));
        }
        $project_name_in_style = $input;

        fwrite(STDOUT, '──────────────────────────────────────────' . "\n");

        $output = 'Add a hyphenated name to use for this project in file folders.' . "\n"
            . "\n"
            . '████ The normal format to use is the kebab-case name of your project,' . "\n"
            . '████ lowercase, with hyphens between words, no spaces.' . "\n";
        fwrite(STDOUT, $output);

        $output = '████ Example: ' . $format->bg_dark_black . $format->fg_bright_yellow . 'my-awesome-project' . $format->reset . "\n";
        fwrite(STDOUT, $output);

        $project_name_hyphenated = '';
        if($is_ready){
            fwrite(STDOUT, "\n");
            $output = $format->reset . 'Hyphenated Project Name to use in file folders: ';
            do{
                $input = readline($output);
            } while(empty($input));
        }
        $project_name_hyphenated = $input;
        $project_app_pack_folder_name = $project_name_hyphenated . '-pack';
        $project_app_pack_front_end_folder_name = $project_name_hyphenated . '-front-end';

        fwrite(STDOUT, '──────────────────────────────────────────' . "\n");

        $output = 'Add a main keywords for this project.' . "\n"
            . "\n"
            . '████ The normal format to use is lower-case, seperated by commas.' . "\n";
        fwrite(STDOUT, $output);
        $output = '████ Ideally only use 3 to 5 keywords' . "\n";
        fwrite(STDOUT, $output);

        $output = '████ Example: ' . $format->bg_dark_black . $format->fg_bright_yellow . 'my awesome project, myawesomeproject, awesome, project' . $format->reset . "\n";
        fwrite(STDOUT, $output);

        $project_main_keywords = '';
        if($is_ready){
            fwrite(STDOUT, "\n");
            $output = $format->reset . 'Project Main Keywords: ';
            do{
                $input = readline($output);
            } while(empty($input));
        }
        $project_main_keywords = $input;

        fwrite(STDOUT, '──────────────────────────────────────────' . "\n");

        $output = 'Add an already-created MariaDB database for the web app to use.' . "\n"
            . "\n"
            . '████ MariaDB database name.' . "\n";
        fwrite(STDOUT, $output);

        $output = '████ Example: ' . $format->bg_dark_black . $format->fg_bright_yellow . 'my_database_name' . $format->reset . "\n";
        fwrite(STDOUT, $output);

        $project_database_name = '';
        if($is_ready){
            fwrite(STDOUT, "\n");
            $output = $format->reset . 'MariaDB database name: ';
            do{
                $input = readline($output);
            } while(empty($input));
        }
        $project_database_name = $input;

        fwrite(STDOUT, '──────────────────────────────────────────' . "\n");

        $output = 'Add an already-created database user for the web app to use.' . "\n"
            . "\n"
            . '████ MariaDB database user.' . "\n";
        fwrite(STDOUT, $output);

        $output = '████ Example: ' . $format->bg_dark_black . $format->fg_bright_yellow . 'my_user' . $format->reset . "\n";
        fwrite(STDOUT, $output);

        $project_database_username = '';
        if($is_ready){
            fwrite(STDOUT, "\n");
            $output = $format->reset . 'MariaDB database user: ';
            do{
                $input = readline($output);
            } while(empty($input));
        }
        $project_database_username = $input;

        fwrite(STDOUT, '──────────────────────────────────────────' . "\n");

        $output = 'Add an already-created database user password for the web app to use.' . "\n"
            . "\n"
            . '████ MariaDB database user password.' . "\n";
        fwrite(STDOUT, $output);

        $output = '████ Example: ' . $format->bg_dark_black . $format->fg_bright_yellow . 'MyPasswordHere!' . $format->reset . "\n";
        fwrite(STDOUT, $output);

        $output = "\n" . $format->bg_bright_yellow . $format->fg_dark_black . ' Warning: This will be stored in text inside the env file. ' . $format->reset . "\n";
        fwrite(STDOUT, $output);

        $project_database_password = '';
        if($is_ready){
            fwrite(STDOUT, "\n");
            $output = $format->reset . 'MariaDB database user password: ';
            do{
                $input = readline($output);
            } while(empty($input));
        }
        $project_database_password = $input;

        fwrite(STDOUT, '──────────────────────────────────────────' . "\n");

        fwrite(STDOUT, 'Summary:' . "\n\n");

        fwrite(STDOUT, 'Project Namespace: ' . $format->fg_bright_cyan . $project_full_namespace . $format->reset . "\n");
        fwrite(STDOUT, 'Migration Namespace: ' . $format->fg_bright_cyan . $migration_namespace . $format->reset . "\n");
        fwrite(STDOUT, 'Project Title: ' . $format->fg_bright_cyan . $project_main_title . $format->reset . "\n");
        fwrite(STDOUT, 'Project Name in PHP: ' . $format->fg_bright_cyan . $project_name_in_php . $format->reset . "\n");
        fwrite(STDOUT, 'Project Name in JS: ' . $format->fg_bright_cyan . $project_name_in_script . $format->reset . "\n");
        fwrite(STDOUT, 'Project Name in CSS: ' . $format->fg_bright_cyan . $project_name_in_style . $format->reset . "\n");
        fwrite(STDOUT, 'Hyphenated Project Name: ' . $format->fg_bright_cyan . $project_name_hyphenated . $format->reset . "\n");
        fwrite(STDOUT, 'Pack Folder Name: ' . $format->fg_bright_cyan . $project_app_pack_folder_name . $format->reset . "\n");
        fwrite(STDOUT, 'Pack Front End Folder Name: ' . $format->fg_bright_cyan . $project_app_pack_front_end_folder_name . $format->reset . "\n");
        fwrite(STDOUT, 'Pack Class Name: ' . $format->fg_bright_cyan . $pack_name . $format->reset . "\n");
        fwrite(STDOUT, 'Project Namespace String: ' . $format->fg_bright_cyan . $project_namespace_string . $format->reset . "\n");
        fwrite(STDOUT, 'Pack Namespace String: ' . $format->fg_bright_cyan . $pack_namespace_string . $format->reset . "\n");
        fwrite(STDOUT, 'Project Keywords: ' . $format->fg_bright_cyan . $project_main_keywords . $format->reset . "\n");
        fwrite(STDOUT, 'Database Name: ' . $format->fg_bright_cyan . $project_database_name . $format->reset . "\n");
        fwrite(STDOUT, 'Database Username: ' . $format->fg_bright_cyan . $project_database_username . $format->reset . "\n");
        fwrite(STDOUT, 'Database Password: ' . $format->fg_bright_cyan . $project_database_password . $format->reset . "\n");

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
            $this->createFromTemplateFileIfNotExists('./vendor/pith/framework/config/setup-templates/env.setup.dist.txt', './env.php', [
                '%[^DATABASE_NAME]%'          => $project_database_name,
                '%[^DATABASE_USER_USERNAME]%' => $project_database_username,
                '%[^DATABASE_USER_PASSWORD]%' => $project_database_password,
            ]);

            // Front Controller
            $this->copyFileIfNotExists('./vendor/pith/framework/front-controller.php', './front-controller.php');

            // Migrations tool
            $this->copyFileIfNotExists('./vendor/pith/framework/mig', './mig');
            $this->copyFileIfNotExists('./vendor/pith/framework/migration-config.php', './migration-config.php');

            // Pith command tool
            $this->copyFileIfNotExists('./vendor/pith/framework/pith', './pith');

            // Task tool
            $this->copyFileIfNotExists('./vendor/pith/framework/task', './task');
            
            // Tracked Constants
            $this->createFromTemplateFileIfNotExists('./vendor/pith/framework/config/setup-templates/tracked-constants.setup.dist.txt', './tracked-constants.php', [
                '%[^PROJECT_NAMESPACE]%'           => $this->convertBackslashesToDoubleBackslashes($project_full_namespace),
                '%[^PROJECT_MIGRATION_NAMESPACE]%' => $this->convertBackslashesToDoubleBackslashes($migration_namespace),
                '%[^PROJECT_MAIN_TITLE]%'          => $project_main_title,
                '%[^PROJECT_MAIN_TITLE_IN_PHP]%'   => $project_name_in_php,
                '%[^PROJECT_MAIN_TITLE_IN_JS]%'    => $project_name_in_script,
                '%[^PROJECT_MAIN_TITLE_IN_CSS]%'   => $project_name_in_style,
                '%[^PROJECT_NAME_HYPHENATED]%'     => $project_name_hyphenated,
                '%[^PROJECT_META_KEYWORDS]%'       => $project_main_keywords,
                '%[^APP_ROUTE_LIST]%'              => $this->doubleBackslashAndStartsWithDoubleBackslash($project_full_namespace) . '\\\\' . $project_name_in_php . 'AppRouteList',
            ]);

            // composer.json
            $this->addProjectNamespacesToComposerDotJson($project_full_namespace, $migration_namespace, $project_app_pack_folder_name, $project_app_pack_front_end_folder_name);

            // App Route List
            $this->createFromTemplateFileIfNotExists('./vendor/pith/framework/config/setup-templates/app-route-list.setup.dist.txt', './src/' . $project_name_in_php .'AppRouteList.php', [
                '%[^PROJECT_MAIN_TITLE]%'           => $project_main_title,
                '%[^PROJECT_MAIN_TITLE_UNDERLINE]%' => $this->charToStringLength('─', $project_main_title),
                '%[^PROJECT_MAIN_TITLE_IN_PHP]%'    => $project_name_in_php,
                '%[^PROJECT_NAMESPACE]%'            => $project_full_namespace,
                '%[^PROJECT_NAMESPACE_STRING]%'     => $project_namespace_string,
            ]);

            // Pack folder
            $this->existFolder('./src/' . $project_app_pack_folder_name);

            // Pack
            $template = './vendor/pith/framework/config/setup-templates/for-pack/app-pack.setup.dist.txt';
            $destination = './src/' . $project_app_pack_folder_name .'/'. $project_name_in_php . 'Pack.php';
            $this->createFromTemplateFileIfNotExists($template, $destination, [
                '%[^PROJECT_MAIN_TITLE]%'           => $project_main_title,
                '%[^PROJECT_MAIN_TITLE_UNDERLINE]%' => $this->charToStringLength('─', $project_main_title),
                '%[^PROJECT_MAIN_TITLE_IN_PHP]%'    => $project_name_in_php,
                '%[^PROJECT_NAMESPACE]%'            => $project_full_namespace,
            ]);

            // Add sub-folders to the Pack folder
            $this->existFolder('./src/' . $project_app_pack_folder_name . '/features');
            $this->existFolder('./src/' . $project_app_pack_folder_name . '/resources');
            $this->existFolder('./src/' . $project_app_pack_folder_name . '/services');

            // Add services
            // TODO

            // Add resource folder
            $this->existFolder('./src/' . $project_app_pack_folder_name . '/resources/' . $project_app_pack_front_end_folder_name);


            // Add app resource route
            $template = './vendor/pith/framework/config/setup-templates/for-pack/for-resources/AppResourceRoute.setup.dist.txt';
            $destination = './src/' . $project_app_pack_folder_name .'/resources/' . $project_app_pack_front_end_folder_name . '/' . $project_name_in_php . 'AppResourceRoute.php';
            $this->createFromTemplateFileIfNotExists($template, $destination, [
                '%[^PROJECT_MAIN_TITLE]%'           => $project_main_title,
                '%[^PROJECT_MAIN_TITLE_UNDERLINE]%' => $this->charToStringLength('-', $project_main_title),
                '%[^PROJECT_MAIN_TITLE_IN_PHP]%'    => $project_name_in_php,
                '%[^PROJECT_NAMESPACE]%'            => $project_full_namespace,
                '%[^PACK_NAMESPACE_STRING]%'        => $pack_namespace_string,
            ]);

            // Add resources
            $this->existFolder('./src/' . $project_app_pack_folder_name . '/resources/' . $project_app_pack_front_end_folder_name . '/resource');
            $this->existFolder('./src/' . $project_app_pack_folder_name . '/resources/' . $project_app_pack_front_end_folder_name . '/resource/features');
            $this->existFolder('./src/' . $project_app_pack_folder_name . '/resources/' . $project_app_pack_front_end_folder_name . '/resource/features/main-layout');

            // Add main layout stylesheet
            $template = './vendor/pith/framework/config/setup-templates/for-pack/for-layout/main-layout-stylesheet.setup.dist.txt';
            $destination = './src/' . $project_app_pack_folder_name . '/resources/' . $project_app_pack_front_end_folder_name . '/resource/features/main-layout/'. $project_name_in_style .'-main-layout.css';
            $this->copyFileIfNotExists($template, $destination);

            // Add features:

            // Add layouts
            // TODO

            // Add lorem ipsum feature
            $this->existFolder('./src/' . $project_app_pack_folder_name . '/features/lorem-ipsum');
            $this->existFolder('./src/' . $project_app_pack_folder_name . '/features/lorem-ipsum/lorem-ipsum-page');
            $this->existFolder('./src/' . $project_app_pack_folder_name . '/features/lorem-ipsum/lorem-ipsum-no-layout');

            // Lorem ipsum no layout rout
            $template = './vendor/pith/framework/config/setup-templates/for-pack/for-lorem-ipsum/LoremIpsumNoLayoutRoute.setup.dist.txt';
            $destination = './src/' . $project_app_pack_folder_name .'/features/lorem-ipsum/lorem-ipsum-no-layout/LoremIpsumNoLayoutRoute.php';
            $this->createFromTemplateFileIfNotExists($template, $destination, [
                '%[^PROJECT_NAMESPACE]%'     => $project_full_namespace,
                '%[^PACK_NAMESPACE_STRING]%' => $pack_namespace_string,
            ]);

            // Lorem ipsum view
            $template = './vendor/pith/framework/config/setup-templates/for-pack/for-lorem-ipsum/lorem-ipsum-view.latte.txt';
            $destination = './src/' . $project_app_pack_folder_name .'/features/lorem-ipsum/lorem-ipsum-no-layout/lorem-ipsum-view.latte';
            $this->copyFileIfNotExists($template, $destination);
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

    public function createFromTemplateFileIfNotExists(string $vendor_template_file_path, string $destination_file_path, array $replacements){
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

            // Get content
            $template_content = file_get_contents($vendor_template_file_path);
            $did_get_template_content = $template_content !== false;

            if($did_get_template_content){
                $output = $format->fg_bright_green . '        ✔ Retrieved template.' . $format->reset . "\n";
                fwrite(STDOUT, $output);

                // Add the new file
                $did_copy = @copy($vendor_template_file_path, $destination_file_path);

                if($did_copy){
                    $output = $format->fg_bright_green . '        ✹ Added the '. $destination_file_path .' file.' . $format->reset . "\n";
                    fwrite(STDOUT, $output);

                    $content = $template_content;
                    foreach ($replacements as $replacement_key => $replacement_value) {
                        $content = str_replace($replacement_key, $replacement_value, $content);
                    }

                    // Write to file
                    $content_bytes_total = strlen($content);
                    $content_bytes_written = file_put_contents($destination_file_path, $content);
                    $did_write_full_content = $content_bytes_written === $content_bytes_total;

                    if($did_write_full_content){
                        $output = $format->fg_bright_green . '        ✔ Wrote values into the '. $destination_file_path .' file.' . $format->reset . "\n";
                        fwrite(STDOUT, $output);
                    }
                    else {
                        $output = $format->fg_bright_red . '        ✘ Failed to write values into the '. $destination_file_path .' file.' . $format->reset . "\n";
                        fwrite(STDOUT, $output);
                    }
                }
                else{
                    $output = $format->fg_bright_red . '        ✘ Failed to add the '. $destination_file_path .' file.' . $format->reset . "\n";
                    fwrite(STDOUT, $output);
                }
            }
            else{
                $output = $format->fg_bright_red . '        ✘ Failed to read content from the '. $destination_file_path .' file.' . $format->reset . "\n";
                fwrite(STDOUT, $output);
            }
        }
    }

    /**
     * @param string $given_string
     * @return string
     */
    public function convertBackslashesToDoubleBackslashes(string $given_string): string
    {
        return str_replace('\\', '\\\\', $given_string);
    }

    public function singleBackslashAndEndWithBackslash(string $given_string): string
    {
        // Turn double-backslashes into single-backslashes
        $converted_string = str_replace('\\\\', '\\', $given_string);

        // End with backslash
        if (!str_ends_with($converted_string, '\\')) {
            $converted_string .= '\\';
        }

        // Return string with single-backslashes, ending with a backslash
        return $converted_string;
    }

    public function doubleBackslashAndStartsWithDoubleBackslash(string $given_string): string
    {
        // Turn single-backslashes into double-backslashes
        //$converted_string = str_replace('\\', '\\\\', $given_string);
        $converted_string = preg_replace('/\\\\/','\\\\\\\\',$given_string);

        // Start with double-backslash
        if (!str_starts_with($converted_string, '\\\\')) {
            $converted_string = '\\\\' . $converted_string;
        }

        // Return string with single-backslashes, ending with a backslash
        return $converted_string;
    }

    public function addProjectNamespacesToComposerDotJson($project_full_namespace, $migration_namespace, $project_app_pack_name, $project_app_pack_front_end_folder_name)
    {
        $format = new CommandLineFormatter();

        $output = '    - Looking at composer.json.' . "\n";
        fwrite(STDOUT, $output);

        $composer_dot_json_array = json_decode(file_get_contents('./composer.json'), true);

        $had_composer_autoload_already_set_up = null;
        if( isset($composer_dot_json_array['autoload']) ) {
            $had_composer_autoload_already_set_up = true;

            $output = $format->fg_bright_yellow . '        ✔ The autoloading already exists.' . $format->reset . "\n";
            fwrite(STDOUT, $output);
        }
        else{
            $had_composer_autoload_already_set_up = false;

            // Add autoload & psr-4
            $composer_dot_json_array['autoload'] = [];
            $composer_dot_json_array['autoload']['psr-4'] = [];

            // Add project namespace
            $composer_dot_json_array['autoload']['psr-4'][$this->singleBackslashAndEndWithBackslash($project_full_namespace)] = [
                'src/',
                'src/' . $project_app_pack_name,
                'src/' . $project_app_pack_name . '/features/',
                'src/' . $project_app_pack_name . '/features/lorem-ipsum/',
                'src/' . $project_app_pack_name . '/features/lorem-ipsum/lorem-ipsum-no-layout/',
                'src/' . $project_app_pack_name . '/features/lorem-ipsum/lorem-ipsum-page/',
                'src/' . $project_app_pack_name . '/resources/',
                'src/' . $project_app_pack_name . '/resources/' . $project_app_pack_front_end_folder_name,
                'src/' . $project_app_pack_name . '/services/',
            ];

            // Add migrations namespace
            $composer_dot_json_array['autoload']['psr-4'][$this->singleBackslashAndEndWithBackslash($migration_namespace)] = [
                'migrations/',
            ];

            // Re-encode
            $composer_dot_json_new_json = json_encode($composer_dot_json_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            $did_encode_composer_dot_json_new_json = $composer_dot_json_new_json != false && strlen($composer_dot_json_new_json) > 0;

            if ($did_encode_composer_dot_json_new_json) {
                // Write to file
                $content_bytes_total = strlen($composer_dot_json_new_json);
                $content_bytes_written = file_put_contents('./composer.json', $composer_dot_json_new_json);
                $did_write_full_content = $content_bytes_written === $content_bytes_total;

                if ($did_write_full_content) {
                    $output = $format->fg_bright_green . '        ✔ Added namespaces into the composer.json file.' . $format->reset . "\n";
                    fwrite(STDOUT, $output);
                }
                else {
                    $output = $format->fg_bright_red . '        ✘ Failed to write namespaces into the composer.json file.' . $format->reset . "\n";
                    fwrite(STDOUT, $output);
                }
            }
            else {
                $output = $format->fg_bright_red . '        ✘ Failed to encode update for composer.json file.' . $format->reset . "\n";
                fwrite(STDOUT, $output);
            }
        }
    }

    /**
     * @noinspection PhpUnnecessaryLocalVariableInspection - For readability
     */
    public function charToStringLength(string $given_char, string $given_string): string
    {
        // Get the given sting length
        $length_to_use = mb_strlen($given_string);

        $output_string = str_repeat($given_char, $length_to_use);

        // Return the output string
        return $output_string;
    }
}
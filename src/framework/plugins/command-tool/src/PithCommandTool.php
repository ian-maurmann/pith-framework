<?php
# ===================================================================
# Copyright (c) 2008-2023 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

declare(strict_types=1);

// Pith Command Tool,
// using Conso ---> lotfio/conso
// See: https://github.com/lotfio/conso
// -----------------------------------------

namespace Pith\CommandTool;

use Conso\Conso;
use Conso\Input;
use Conso\Output;
use DI\Container;
use Pith\Framework\PithInfo;
use Pith\PithDotJson\PithDotJsonService;

class PithCommandTool
{
    private Conso              $conso;
    private Container          $container;
    private PithInfo           $info;
    private PithDotJsonService $pith_dot_json_service;

    function __construct()
    {
        // Forget what files exist / don't exist
        clearstatcache();

        // Add objects to this
        $this->container             = new Container();
        $this->pith_dot_json_service = $this->container->get('\\Pith\\PithDotJson\\PithDotJsonService');
        $this->info                  = $this->container->get('Pith\\Framework\\PithInfo');

        // Set up defaults
        $this->pith_dot_json_service->setLocation('.');
    }

    public function start()
    {
        // Create Conso Input and Output
        $input = new Input;
        $output = new Output;
        @ $this->conso = new Conso($input, $output);

        // Or just use @ for now
        //     // Change error level to avoid PHP deprecated warning about Conso's constructor setting dynamic properties
        //     $previous_error_reporting_level = error_reporting(0);
        //
        //     // Instantiate Conso
        //     $this->conso = new Conso($input, $output);
        //
        //     // Return to previous error level
        //     error_reporting($previous_error_reporting_level);

        // Give setup info to Conso
        $this->initialize();

        // Run Conso
        $this->conso->run();
    }


    private function initialize()
    {
        $this->initializeMetadata();
        $this->initializeSignature();
        $this->initializeCommands();
    }


    private function initializeMetadata(){
        $version = $this->info->getVersionPlusSemver();

        $this->conso->setName('Pith Command Tool');
        $this->conso->setVersion($version);
        $this->conso->setAuthor('Ian Maurmann');
    }


    private function initializeSignature()
    {
        $green_fg  = "\033[32m";
        $normal_fg = "\033[0m";
        $ascii_art = "\n╔══════╗     ╔═╗  ╔═╗    "
                   . "\n║ ╔══╗ ║ ╔═╗ ║ ║  ║ ║    "
                   . "\n║ ╚══╝ ║ ╚═╝ ║ ╚═╗║ ╚═══╗"
                   . "\n║ ╔════╝ ╔═╗ ║ ╔═╝║ ╔═╗ ║"
                   . "\n║ ║      ║ ║ ║ ║  ║ ║ ║ ║"
                   . "\n╚═╝      ╚═╝ ╚═╝  ╚═╝ ╚═╝"
                   . "\n";
        
        $signature = $green_fg . $ascii_art . $normal_fg;
        
        $this->conso->setSignature($signature);
    }


    private function initializeCommands()
    {
        $this->conso->command("install", function($input, $output){

//            $output->writeLn("Not ready yet \n", 'red');

//            $app_name      = readline('App Name: ');
//            $app_namespace = readline('Namespace: ');
//
//            $output->writeLn("\t" . '─────────────────────────────────' . "\n");
//            $output->writeLn("\t" . "\033[32;1m" . 'App Name'  . "\033[0m" . ' = ' . "\033[31;0m" . $app_name      . "\033[0m" . "\n");
//            $output->writeLn("\t" . "\033[32;1m" . 'Namespace' . "\033[0m" . ' = ' . "\033[31;0m" . $app_namespace . "\033[0m" . "\n");
//            $output->writeLn("\t" . '─────────────────────────────────' . "\n");
//
//            $output->writeLn("Not ready yet \n", 'red');

            // Header
            $output->writeLn('╔═══════════════════╗' . "\n");
            $output->writeLn('║ Pith Installer    ║' . "\n");
            $output->writeLn('║ (Not ready yet)   ║' . "\n");
            $output->writeLn('╚═══════════════════╝' . "\n");

            $run_yn = readline('Run the Installer? (Y/N): ');
            $run    = (strtolower($run_yn) === 'y') ? true : false ;

            if($run) {
                // Vars
                $php_di_container = new \DI\Container();
                $pith_dot_json_service = $php_di_container->get('\\Pith\\PithDotJson\\PithDotJsonService');
                $pith_dot_json_service->setLocation('.');
                $does_pith_dot_json_exist = $pith_dot_json_service->doesPithDotJsonExist();

                $output->writeLn("┯ Start install \n", 'yellow');
                $output->writeLn("├┐ \n", 'yellow');
                $output->writeLn("│├ Checking for pith.json\n", 'yellow');

                // Show pith.json exists
                if ($does_pith_dot_json_exist) {
                    $output->writeLn("│└ pith.json exists \n", 'white');
                } else {
                    $output->writeLn("│├ pith.json does not exists \n", 'white');
                }

                // Create new pith.json
                if (!$does_pith_dot_json_exist) {
                    $create_new_pith_dot_json_yn = readline('│┝█ Create new pith.json file? (Y/N): ');
                    $create_new_pith_dot_json = (strtolower($create_new_pith_dot_json_yn) === 'y') ? true : false;

                    if ($create_new_pith_dot_json) {
                        $output->writeLn("│└┐ \n", 'white');
                        $output->writeLn("│ ├ Creating new pith.json \n", 'yellow');

                        $app_name    = readline('│ ┝█ App Name (string): ');
                        $public_path = readline('│ ┝█ Public Folder (relative path): ');

//                        $output->writeLn("│ ├ Generating json... \n", 'yellow');
//
//                        $pith_dot_json_data = [
//                            'app_name' => $app_name,
//                            'public_path' => $public_path,
//                        ];
//
//                        $pith_dot_json_data_json = json_encode($pith_dot_json_data);

                        $output->writeLn("│ ├ Creating file... \n", 'yellow');

                        $pith_dot_json_service->createNewPithDotJson($app_name, $public_path);

                        $was_pith_dot_json_created = $pith_dot_json_service->doesPithDotJsonExist();

                        if($was_pith_dot_json_created){
                            $output->writeLn("│ └ Created pith.json \n", 'white');
                        }
                        else{
                            $output->writeLn("│ └ Failed to create pith.json file, Cannot install \n", 'red');
                        }
                    } else {
                        $output->writeLn("│└ No pith.json file, Cannot install \n", 'red');

                    }
                }
                $output->writeLn("┷ End install \n", 'yellow');
            }
        })->description("Install new app. (Not ready yet)");

        $this->conso->command("verify", function($input, $output){

            $output->writeLn("Cannot verify \n", 'red');

        })->description("Verify the app's installation. (Not ready yet)");

        $this->conso->command("assert", function($input, $output){

            if($input->subCommand() == 'pith_json_exists') {
                // $output->writeLn("Cannot assert that pith.json exists \n", 'red');

                $php_di_container = new \DI\Container();
                $pith_dot_json_service = $php_di_container->get('\\Pith\\PithDotJson\\PithDotJsonService');
                $pith_dot_json_service->setLocation('.');
                $does_pith_dot_json_exist = $pith_dot_json_service->doesPithDotJsonExist();


                if($does_pith_dot_json_exist){
                    $output->writeLn("pith.json exists \n", 'green');
                }
                else{
                    $output->writeLn("pith.json does not exists \n", 'red');
                }
            }
            elseif($input->subCommand() == 'pith_config_exists') {
                $output->writeLn("Cannot assert that Config exists \n", 'red');
            }
            else {
                $output->writeLn("Cannot assert \n", 'red');
            }

        })->description("Assert that parts of the app exist and appear to work. (Not ready yet)")->sub(
            'pith_json_exists',
            'pith_config_exists'
            );
    }
}

<?php
# ===================================================================
# Copyright (c) 2008-2020 Ian K Maurmann. The Pith Framework is
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

use Conso;

class PithCommandTool
{
    private $conso;

    function __construct()
    {

    }

    public function start()
    {
        $this->conso = new Conso\Conso(new Conso\Input, new Conso\Output);

        $this->initialize();

        $this->conso->run();
    }





    private function initialize()
    {
        $this->initializeMetadata();
        $this->initializeSignature();
        $this->initializeCommands();
    }




    private function initializeMetadata(){
        $this->conso->setName('Pith Command Tool');
        $this->conso->setVersion('0.0.0');
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

            $output->writeLn("Not ready yet \n", 'red');

//            $app_name      = readline('App Name: ');
//            $app_namespace = readline('Namespace: ');
//
//            $output->writeLn("\t" . '─────────────────────────────────' . "\n");
//            $output->writeLn("\t" . "\033[32;1m" . 'App Name'  . "\033[0m" . ' = ' . "\033[31;0m" . $app_name      . "\033[0m" . "\n");
//            $output->writeLn("\t" . "\033[32;1m" . 'Namespace' . "\033[0m" . ' = ' . "\033[31;0m" . $app_namespace . "\033[0m" . "\n");
//            $output->writeLn("\t" . '─────────────────────────────────' . "\n");
//
//            $output->writeLn("Not ready yet \n", 'red');


        })->description("Install new app. (Not ready yet)");



        $this->conso->command("verify", function($input, $output){

            $output->writeLn("Cannot verify \n", 'red');

        })->description("Verify the app's installation. (Not ready yet)");


        $this->conso->command("assert", function($input, $output){


            if($input->subCommand() == 'pith_json_exists') {
                $output->writeLn("Cannot assert that pith.json exists \n", 'red');
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
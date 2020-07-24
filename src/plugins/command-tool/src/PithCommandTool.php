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
        
        $signature = $green_fg . $ascii_art . $normal_fg;
        
        $this->conso->setSignature($signature);
    }





    private function initializeCommands()
    {
        $this->conso->command("test", function($input, $output){

            if($input->subCommand() == 'one')
                exit($output->writeLn("\n hello from one \n", 'yellow'));

            if($input->subCommand() == 'two')
                $output->writeLn("hello from two \n", 'green');

        })->description("This is test command description :) ^^")->sub('one', 'two');




    }







}
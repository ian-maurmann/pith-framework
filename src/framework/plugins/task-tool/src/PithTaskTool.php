<?php
# ===================================================================
# Copyright (c) 2008-2023 Ian K Maurmann. The Pith Framework is
# provided under the terms of the Mozilla Public License, v. 2.0
#
# This Source Code Form is subject to the terms of the Mozilla Public
# License, v. 2.0. If a copy of the MPL was not distributed with this
# file, You can obtain one at http://mozilla.org/MPL/2.0/.
# ===================================================================

/**
 * Pith Task Tool
 * ---------------
 *
 */

declare(strict_types=1);


namespace Pith\TaskTool;

use DI\Container;
use Pith\Framework\Internal\PithArrayUtility;
use Pith\Framework\PithCliFormat;
use Pith\Framework\PithCliWriter;
use Pith\Framework\PithInfo;


class PithTaskTool
{
    private PithArrayUtility $array_utility;
    private PithCliFormat    $cli_format;
    private PithCliWriter    $cli_writer;
    private Container        $container;
    private PithInfo         $info;

    public function __construct()
    {
        // Add objects
        $this->container     = new Container();
        $this->array_utility = $this->container->get('Pith\\Framework\\Internal\\PithArrayUtility');
        $this->cli_format    = $this->container->get('Pith\\Framework\\PithCliFormat');
        $this->cli_writer    = $this->container->get('Pith\\Framework\\PithCliWriter');
        $this->info          = $this->container->get('Pith\\Framework\\PithInfo');
    }

    public function run()
    {
        $hasParams = false;
        $hasOptions = false;

        // Short Options
        // ==============================================================
        // $short_options  = "";
        // $short_options .= "f:";  // Required value
        // $short_options .= "v::"; // Optional value
        // $short_options .= "abc"; // These options do not accept values
        // ==============================================================

        // Short Options
        $short_options  = '';
        $short_options .= 'v::';
        $short_options .= 'V::';

        // Long Options
        // ==============================================================
        // $long_options  = array(
        //     "required:",     // Required value
        //     "optional::",    // Optional value
        //     "option",        // No value
        //     "opt",           // No value
        // );
        // ==============================================================

        // Long Options
        $long_options = [
            'version::',
            'Version::',
        ];

        // Get Options
        $options = getopt($short_options, $long_options);
        $option_keys = array_keys($options);



        $has_version_flag = $this->array_utility->arrayHasValueInsensitive($option_keys,'v') || $this->array_utility->arrayHasValueInsensitive($option_keys,'version');
        if($has_version_flag){
            $this->displayVersion();
            return;
        }

        if(!$hasOptions && !$hasParams){
            $this->displayInfo();
        }
    }

    public function displayInfo()
    {
        $writer = $this->cli_writer;
        $format = $this->cli_format;

        $writer->writeLine($format->bg_dark_black . $format->fg_bright_yellow);
        $writer->writeLine('Pith Task Tool');
        $writer->writeLine('    ' . 'Tool for running commands from the command line.');
        $writer->writeLine('    ');
        $writer->writeLine('    ' . '╭─────────────────────────────────────────────────────────╮');
        $writer->writeLine('    ' . '  ' . $this->info->getVersionSlug());
        $writer->writeLine('    ' . '  ' .'Released under license: ' . $this->info->getLicenseName());
        $writer->writeLine('    ' . '  ' .$this->info->getCopyrightNotice());
        $writer->writeLine('    ' . '╰─────────────────────────────────────────────────────────╯');
        $writer->writeLine('    ');
        $writer->writeLine('    ' . '- Thanks!');
        $writer->writeLine('    ' . '- Ian M.');
        $writer->writeLine($format->reset);
    }

    public function displayVersion()
    {
        $writer = $this->cli_writer;

        $writer->writeLine($this->info->getVersionPlusSemver());
    }
}
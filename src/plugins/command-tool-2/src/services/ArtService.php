<?php

/**
 * Art Service
 * -----------
 *
 * @noinspection PhpMethodNamingConventionInspection
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\CommandTool2;

use IKM\CLI\CommandLineFormatter;
use IKM\CLI\CommandLineWriter;
use IKM\CLI\TerminalUtility;

/**
 * Class ArtService
 */
class ArtService
{
    private CommandLineFormatter $formatter;
    private CommandLineWriter    $writer;
    private TerminalUtility $terminal_utility;

    public function __construct()
    {
        // Get CLI tools
        $this->writer           = new CommandLineWriter();
        $this->formatter        = new CommandLineFormatter();
        $this->terminal_utility = new TerminalUtility();
    }

    public function drawPithFrameworkLogo(): void
    {
        $art_writer = new ArtWriter();

        $terminal_width = $this->terminal_utility->getTerminalWidth();

        if($terminal_width >= 136){
            $art_writer->drawPithFrameworkLogoAt136Wide();
        }
        elseif($terminal_width >= 75){
            $art_writer->drawPithFrameworkLogoAt75Wide();
        }
        elseif($terminal_width >= 40){
            $art_writer->drawPithFrameworkLogoAt40Wide();
        }
        elseif($terminal_width >= 14){
            $art_writer->drawPithFrameworkLogoAt14Wide();
        }
        else{
            $art_writer->drawPithFrameworkLogoAt9Wide();
        }


    }

}
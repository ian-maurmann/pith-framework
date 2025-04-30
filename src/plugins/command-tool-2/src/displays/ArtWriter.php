<?php

/**
 * Art Writer
 * ----------
 *
 * @noinspection PhpMethodNamingConventionInspection - Long method names are ok here.
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\CommandTool2;


use Conso\Contracts\CommandInterface;
use IKM\CLI\CommandLineFormatter;
use IKM\CLI\CommandLineWriter;

/**
 * Class ArtWriter
 */
class ArtWriter
{
    private CommandLineFormatter $formatter;
    private CommandLineWriter    $writer;

    public function __construct()
    {
        // Do nothing for now.

        // Get CLI tools
        $this->writer    = new CommandLineWriter();
        $this->formatter = new CommandLineFormatter();
    }

    public function drawPithFrameworkLogoAt9Wide(): void
    {
        $writer = new CommandLineWriter();
        $format = new \IKM\CLI\CommandLineFormatter();

        $writer->br();

        $writer->write($format->fg_bright_green);
        $writer->writeLine("Pith\nFramework");
        $writer->write($format->reset);

        $writer->br();
    }

    public function drawPithFrameworkLogoAt14Wide(): void
    {
        $writer = new CommandLineWriter();
        $format = new \IKM\CLI\CommandLineFormatter();

        $writer->br();

        $writer->write($format->fg_bright_green);
        $writer->writeLine('Pith Framework');
        $writer->write($format->reset);

        $writer->br();
    }

    public function drawPithFrameworkLogoAt40Wide(): void
    {
        $writer = new CommandLineWriter();
        $format = new \IKM\CLI\CommandLineFormatter();

        $writer->br();

        $writer->write($format->fg_bright_green);
        $writer->writeLine('⠀⠀⠀⠀⣠⣴⣶⣶⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠇⠀⠀⣾⣿⣶⣶⣦⣄⠀⠀⠀⠀');
        $writer->writeLine('⠀⠀⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡏⠀⠀⣼⣿⣿⣿⣿⣿⣿⣿⣦⠀⠀');
        $writer->writeLine('⢀⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠀⠀⣰⣿⣿⣿⣿⣿⣿⣿⣿⣿⣷⡀');
        $writer->writeLine('⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠃⠀⢠⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇');
        $writer->writeLine('⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠃⠀⢀⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠿⠋');
        $writer->writeLine('⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇⠀⠀⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠃⠀⠀');
        $writer->writeLine('⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡏⠀⠀⣼⣿⣿⣿⣿⣿⣿⣿⡿⠟⠁⠀⠀⠀⢀');
        $writer->writeLine('⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡏⠀⠀⣼⣿⣿⣿⣿⣿⣿⠟⠉⠀⠀⠀⢀⣠⣾⣿');
        $writer->writeLine('⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡟⠀⠀⣼⣿⣿⣿⣿⠟⠋⠁⠀⠀⢀⣠⣶⣿⣿⣿⣿');
        $writer->writeLine('⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠀⢀⣼⣿⣿⠟⠋⠁⠀⠀⢀⣤⣶⣿⣿⣿⣿⣿⣿⣿');
        $writer->writeLine('⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠀⠀⡾⠟⠋⠀⠀⠀⢀⣤⣶⣿⣿⣿⣿⠿⠿⠿⠿⠿⠿');
        $writer->writeLine('⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠃⠀⠀⠊⠀⠀⠀⠀⠀⠊⠉⠉⠁⠀⠀⠀⣀⣀⣀⣀⣀⣀⣀');
        $writer->writeLine('⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠁⠀⠀⠀⠀⠀⣀⣤⣤⣴⣶⣶⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿');
        $writer->writeLine('⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠿⠛⠁⠀⠀⠀⠀⣠⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿');
        $writer->writeLine('⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠋⠁⠀⠀⠀⠀⣠⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿');
        $writer->writeLine('⣿⣿⣿⣿⣿⠟⠛⠉⠀⠀⠀⠀⠀⠀⠐⠚⠛⠛⠛⠛⠛⠛⠻⠿⠿⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿');
        $writer->writeLine('⠸⠟⠛⠉⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⣀⣀⣀⣀⣀⣀⡀⠀⠀⠀⠀⠀⠀⠈⠉⠉⠛⠛⠛⠛⠛⠿⠿⠿⡇');
        $writer->writeLine('⠀⠀⠀⠀⠀⠀⠀⠀⣠⣴⣶⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣶⣶⣶⣤⣤⣤⣤⣀⣀⣀⣀⠀⠀⠀');
        $writer->writeLine('⠀⠀⠀⠀⠀⢀⣠⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠀⠀');
        $writer->writeLine('⠀⠀⠀⠀⠐⠻⠿⠿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠿⠿⠟⠋⠀⠀⠀⠀');
        $writer->write($format->reset);

        $writer->br();
    }

    public function drawPithFrameworkLogoAt75Wide(): void
    {
        $writer = new CommandLineWriter();
        $format = new \IKM\CLI\CommandLineFormatter();

        $reset = $format->reset;
        $green = $format->fg_bright_green;

        $writer->br();

        $writer->writeLine($green . '⠀⠀⠀⠀⣠⣴⣶⣶⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠇⠀⠀⣾⣿⣶⣶⣦⣄⠀⠀⠀⠀' . $reset);
        $writer->writeLine($green . '⠀⠀⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡏⠀⠀⣼⣿⣿⣿⣿⣿⣿⣿⣦⠀⠀' . $reset);
        $writer->writeLine($green . '⢀⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠀⠀⣰⣿⣿⣿⣿⣿⣿⣿⣿⣿⣷⡀' . $reset);
        $writer->writeLine($green . '⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠃⠀⢠⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇' . $reset);
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠃⠀⢀⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠿⠋' . $reset);
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇⠀⠀⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠃⠀⠀' . $reset);
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡏⠀⠀⣼⣿⣿⣿⣿⣿⣿⣿⡿⠟⠁⠀⠀⠀⢀' . $reset . '   ⣤⣤⣤⣤⣤⣤⣤⣄⠀⠀⠀⣤⣤⣤⠀⠀⠀⣀⣀⡀⠀⠀⠀⢰⣶⣶⠀⠀⠀⠀⠀⠀');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡏⠀⠀⣼⣿⣿⣿⣿⣿⣿⠟⠉⠀⠀⠀⢀⣠⣾⣿' . $reset . '   ⣿⣿⣿⠿⠿⠿⣿⣿⣷⡀⠀⠛⠛⠛⠀⠀⠀⣿⣿⡇⠀⠀⠀⢸⣿⣿⠀⠀⠀⠀⠀⠀');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡟⠀⠀⣼⣿⣿⣿⣿⠟⠋⠁⠀⠀⢀⣠⣶⣿⣿⣿⣿' . $reset . '   ⣿⣿⣿⠀⠀⠀⢸⣿⣿⡇⠀⣤⣤⣤⠀⢰⣶⣿⣿⣷⣶⣶⠀⢸⣿⣿⣶⣾⣿⣶⣦⡀');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠀⢀⣼⣿⣿⠟⠋⠁⠀⠀⢀⣤⣶⣿⣿⣿⣿⣿⣿⣿' . $reset . '   ⣿⣿⣿⠀⠀⠀⣸⣿⣿⡇⠀⣿⣿⣿⠀⠘⠛⣿⣿⡟⠛⠋⠀⢸⣿⣿⠟⠉⠙⣿⣿⣷');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠀⠀⡾⠟⠋⠀⠀⠀⢀⣤⣶⣿⣿⣿⣿⠿⠿⠿⠿⠿⠿' . $reset . '   ⣿⣿⣿⣿⣿⣿⣿⣿⠟⠀⠀⣿⣿⣿⠀⠀⠀⣿⣿⡇⠀⠀⠀⢸⣿⣿⠀⠀⠀⣿⣿⣿');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠃⠀⠀⠊⠀⠀⠀⠀⠀⠊⠉⠉⠁⠀⠀⠀⣀⣀⣀⣀⣀⣀⣀' . $reset . '   ⣿⣿⣿⠉⠉⠉⠉⠀⠀⠀⠀⣿⣿⣿⠀⠀⠀⣿⣿⡇⠀⠀⠀⢸⣿⣿⠀⠀⠀⣿⣿⣿');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠁⠀⠀⠀⠀⠀⣀⣤⣤⣴⣶⣶⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿' . $reset . '   ⣿⣿⣿⠀⠀⠀⠀⠀⠀⠀⠀⣿⣿⣿⠀⠀⠀⣿⣿⣷⣶⣦⠀⢸⣿⣿⠀⠀⠀⣿⣿⣿');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠿⠛⠁⠀⠀⠀⠀⣠⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿' . $reset . '   ⠛⠛⠛⠀⠀⠀⠀⠀⠀⠀⠀⠛⠛⠛⠀⠀⠀⠈⠛⠛⠛⠋⠀⠘⠛⠛⠀⠀⠀⠙⠛⠛');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠋⠁⠀⠀⠀⠀⣠⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿' . $reset);
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⠟⠛⠉⠀⠀⠀⠀⠀⠀⠐⠚⠛⠛⠛⠛⠛⠛⠻⠿⠿⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿' . $reset);
        $writer->writeLine($green . '⠸⠟⠛⠉⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⣀⣀⣀⣀⣀⣀⡀⠀⠀⠀⠀⠀⠀⠈⠉⠉⠛⠛⠛⠛⠛⠿⠿⠿⡇' . $reset);
        $writer->writeLine($green . '⠀⠀⠀⠀⠀⠀⠀⠀⣠⣴⣶⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣶⣶⣶⣤⣤⣤⣤⣀⣀⣀⣀⠀⠀⠀' . $reset);
        $writer->writeLine($green . '⠀⠀⠀⠀⠀⢀⣠⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠀⠀' . $reset);
        $writer->writeLine($green . '⠀⠀⠀⠀⠐⠻⠿⠿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠿⠿⠟⠋⠀⠀⠀⠀' . $reset);
        $writer->write($format->reset);

        $writer->br();
    }

    public function drawPithFrameworkLogoAt136Wide(): void
    {
        $writer = new CommandLineWriter();
        $format = new \IKM\CLI\CommandLineFormatter();

        $reset = $format->reset;
        $green = $format->fg_bright_green;

        $writer->br();

        $writer->writeLine($green . '⠀⠀⠀⠀⣠⣴⣶⣶⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠇⠀⠀⣾⣿⣶⣶⣦⣄⠀⠀⠀⠀' . $reset);
        $writer->writeLine($green . '⠀⠀⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡏⠀⠀⣼⣿⣿⣿⣿⣿⣿⣿⣦⠀⠀' . $reset . '   ⣤⣤⣤⣤⣤⣤⣤⣄⠀⠀⠀⣤⣤⣤⠀⠀⠀⣀⣀⡀⠀⠀⠀⢰⣶⣶⠀⠀⠀⠀⠀');
        $writer->writeLine($green . '⢀⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠀⠀⣰⣿⣿⣿⣿⣿⣿⣿⣿⣿⣷⡀' . $reset . '   ⣿⣿⣿⠿⠿⠿⣿⣿⣷⡀⠀⠛⠛⠛⠀⠀⠀⣿⣿⡇⠀⠀⠀⢸⣿⣿⠀⠀');
        $writer->writeLine($green . '⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠃⠀⢠⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇' . $reset . '   ⣿⣿⣿⠀⠀⠀⢸⣿⣿⡇⠀⣤⣤⣤⠀⢰⣶⣿⣿⣷⣶⣶⠀⢸⣿⣿⣶⣾⣿⣶⣦⡀⠀⠀⠀⠀⠀⠀');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠃⠀⢀⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠿⠋' . $reset . '   ⣿⣿⣿⠀⠀⠀⣸⣿⣿⡇⠀⣿⣿⣿⠀⠘⠛⣿⣿⡟⠛⠋⠀⢸⣿⣿⠟⠉⠙⣿⣿⣷⠀⠀');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇⠀⠀⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠃⠀⠀' . $reset . '   ⣿⣿⣿⣿⣿⣿⣿⣿⠟⠀⠀⣿⣿⣿⠀⠀⠀⣿⣿⡇⠀⠀⠀⢸⣿⣿⠀⠀⠀⣿⣿⣿⠀⠀⠀⠀⠀');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡏⠀⠀⣼⣿⣿⣿⣿⣿⣿⣿⡿⠟⠁⠀⠀⠀⢀' . $reset . '   ⣿⣿⣿⠉⠉⠉⠉⠀⠀⠀⠀⣿⣿⣿⠀⠀⠀⣿⣿⡇⠀⠀⠀⢸⣿⣿⠀⠀⠀⣿⣿⣿⠀');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡏⠀⠀⣼⣿⣿⣿⣿⣿⣿⠟⠉⠀⠀⠀⢀⣠⣾⣿' . $reset . '   ⣿⣿⣿⠀⠀⠀⠀⠀⠀⠀⠀⣿⣿⣿⠀⠀⠀⣿⣿⣷⣶⣦⠀⢸⣿⣿⠀⠀⠀⣿⣿⣿⠀⠀⠀⠀⠀⠀');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡟⠀⠀⣼⣿⣿⣿⣿⠟⠋⠁⠀⠀⢀⣠⣶⣿⣿⣿⣿' . $reset . '   ⠛⠛⠛⠀⠀⠀⠀⠀⠀⠀⠀⠛⠛⠛⠀⠀⠀⠈⠛⠛⠛⠋⠀⠘⠛⠛⠀⠀⠀⠙⠛⠛⠀⠀⠀⠀⠀⠀');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠀⢀⣼⣿⣿⠟⠋⠁⠀⠀⢀⣤⣶⣿⣿⣿⣿⣿⣿⣿' . $reset . '   ');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠀⠀⡾⠟⠋⠀⠀⠀⢀⣤⣶⣿⣿⣿⣿⠿⠿⠿⠿⠿⠿' . $reset . '   ');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⠃⠀⠀⠊⠀⠀⠀⠀⠀⠊⠉⠉⠁⠀⠀⠀⣀⣀⣀⣀⣀⣀⣀' . $reset . '   ⢠⣤⣤⣤⣤⣤⣤⣤⡄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢰⣶⣶⡆⠀⠀⠀⠀⠀⠀');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠁⠀⠀⠀⠀⠀⣀⣤⣤⣴⣶⣶⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿' . $reset . '   ⢸⣿⣿⡿⠿⠿⠿⠿⠇⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢸⣿⣿⡇⠀⠀⠀⠀⠀⠀');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠿⠛⠁⠀⠀⠀⠀⣠⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿' . $reset . '   ⢸⣿⣿⡇⠀⠀⠀⠀⠀⠀⣶⣶⣶⣴⣶⣿⠀⢀⣴⣶⣿⣿⣶⣦⡀⠀⠀⣶⣶⣶⣶⣾⣷⣶⣤⣶⣾⣿⣷⣦⡀⠀⠀⢀⣴⣶⣿⣿⣶⣦⡀⠐⣶⣶⡆⠀⠀⣰⣶⣶⡄⠀⠀⣴⣶⡶⠀⣠⣶⣶⣿⣿⣶⣦⡀⠀⠀⣶⣶⣦⣶⣶⣷⢸⣿⣿⡇⠀⠀⣴⣶⣶⠆');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠋⠁⠀⠀⠀⠀⣠⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿' . $reset . '   ⢸⣿⣿⣷⣶⣶⣶⣶⡄⠀⣿⣿⣿⠿⠛⠛⠀⣿⣿⡟⠋⠙⣿⣿⣧⠀⠀⣿⣿⣿⠛⠉⢻⣿⣿⡟⠋⠙⢻⣿⣿⠀⢠⣿⣿⡟⠋⠙⢻⣿⣿⠀⢻⣿⣷⠀⢀⣿⣿⣿⣧⠀⢠⣿⣿⠇⢰⣿⣿⠟⠉⠙⢿⣿⣿⠀⠀⣿⣿⡿⠟⠛⠃⢸⣿⣿⡇⣠⣾⣿⡿⠃⠀');
        $writer->writeLine($green . '⣿⣿⣿⣿⣿⠟⠛⠉⠀⠀⠀⠀⠀⠀⠐⠚⠛⠛⠛⠛⠛⠛⠻⠿⠿⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿' . $reset . '   ⢸⣿⣿⡟⠛⠛⠛⠛⠃⠀⣿⣿⣿⠀⠀⠀⠀⠀⣀⣤⣴⣾⣿⣿⣿⠀⠀⣿⣿⣿⠀⠀⢸⣿⣿⡇⠀⠀⢸⣿⣿⠀⢸⣿⣿⣷⣶⣶⣿⣿⣿⠀⠈⣿⣿⡆⣸⣿⡿⣿⣿⡆⣼⣿⡿⠀⢸⣿⣿⠀⠀⠀⢸⣿⣿⠀⠀⣿⣿⡇⠀⠀⠀⢸⣿⣿⣿⣿⣿⡋⠀⠀⠀');
        $writer->writeLine($green . '⠸⠟⠛⠉⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⣀⣀⣀⣀⣀⣀⡀⠀⠀⠀⠀⠀⠀⠈⠉⠉⠛⠛⠛⠛⠛⠿⠿⠿⡇' . $reset . '   ⢸⣿⣿⡇⠀⠀⠀⠀⠀⠀⣿⣿⣿⠀⠀⠀⢠⣿⣿⡿⠛⠋⣿⣿⣿⠀⠀⣿⣿⣿⠀⠀⢸⣿⣿⡇⠀⠀⢸⣿⣿⠀⢸⣿⣿⡏⠉⠉⠉⠉⠉⠀⠀⢸⣿⣿⣿⣿⠃⢹⣿⣿⣿⣿⠁⠀⢸⣿⣿⠀⠀⠀⢸⣿⣿⠀⠀⣿⣿⡇⠀⠀⠀⢸⣿⣿⡿⢻⣿⣿⣄⠀⠀');
        $writer->writeLine($green . '⠀⠀⠀⠀⠀⠀⠀⠀⣠⣴⣶⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣶⣶⣶⣤⣤⣤⣤⣀⣀⣀⣀⠀⠀⠀' . $reset . '   ⢸⣿⣿⡇⠀⠀⠀⠀⠀⠀⣿⣿⣿⠀⠀⠀⠘⣿⣿⣧⣤⣴⣿⣿⣿⣤⠀⣿⣿⣿⠀⠀⢸⣿⣿⡇⠀⠀⢸⣿⣿⠀⠈⣿⣿⣷⣤⣤⣼⣿⣿⠀⠀⠀⣿⣿⣿⡏⠀⠀⣿⣿⣿⡏⠀⠀⠸⣿⣿⣦⣤⣤⣾⣿⡿⠀⠀⣿⣿⡇⠀⠀⠀⢸⣿⣿⡇⠀⠹⣿⣿⣦⡀');
        $writer->writeLine($green . '⠀⠀⠀⠀⠀⢀⣠⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠟⠀⠀' . $reset . '   ⠘⠛⠛⠃⠀⠀⠀⠀⠀⠀⠛⠛⠛⠀⠀⠀⠀⠈⠛⠿⠿⠛⠉⠛⠛⠋⠀⠛⠛⠛⠀⠀⠘⠛⠛⠃⠀⠀⠘⠛⠛⠀⠀⠈⠛⠻⠿⠿⠟⠛⠁⠀⠀⠀⠘⠛⠛⠁⠀⠀⠘⠛⠛⠁⠀⠀⠀⠈⠛⠻⠿⠿⠛⠋⠁⠀⠀⠛⠛⠃⠀⠀⠀⠘⠛⠛⠃⠀⠀⠈⠛⠛⠛');
        $writer->writeLine($green . '⠀⠀⠀⠀⠐⠻⠿⠿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠿⠿⠟⠋⠀⠀⠀⠀' . $reset);
        $writer->write($format->reset);

        $writer->br();
    }

}
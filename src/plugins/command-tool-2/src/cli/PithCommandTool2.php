<?php /** @noinspection PhpVariableNamingConventionInspection */

/**
 * Pith Command Tool 2
 * -------------------
 *
 * @noinspection PhpPropertyNamingConventionInspection - Properties with underscores are ok.
 * @noinspection PhpMethodNamingConventionInspection   - Short method names are ok.
 * @noinspection PhpVariableNamingConventionInspection - Short PHP predefined variable names like $argv are ok.
 */

declare(strict_types=1);

namespace Pith\Framework\Plugin\CommandTool2;

use DI\Container;
use Exception;
use IKM\CLI\CommandLineFormatter;
use IKM\CLI\CommandLineWriter;
use Pith\Framework\PithAppRetriever;

/**
 * Class PithCommandTool2
 * @package Pith\Framework\Plugin\CommandTool2
 */
class PithCommandTool2
{
    private PithAppRetriever $app_retriever;
    private ArrayUtility $array_utility;
    private CommandLineFormatter $formatter;
    private CommandLineWriter $writer;
    private Container $container;
    private string $version_number;

    public function __construct()
    {
        $this->container     = new Container();
        $this->app_retriever = $this->container->get('Pith\\Framework\\PithAppRetriever');
        // Set object dependencies
        $this->array_utility = new ArrayUtility();

        // Get CLI tools
        $this->writer    = new CommandLineWriter();
        $this->formatter = new CommandLineFormatter();

        // Set Info
        $this->version_number = 'Pith Command Tool 2 v0.0.0 (WIP)';
    }

    /**
     * @noinspection PhpConcatenationWithEmptyStringCanBeInlinedInspection - Ignore.
     * @noinspection DuplicatedCode
     */
    public function run()
    {
        global $argv; // PHP predefined var
        $file = $argv[0] ?? '';
        $positional_parameter_1 = $argv[1] ?? '';
        $positional_parameter_2 = $argv[2] ?? '';
        $positional_parameter_3 = $argv[3] ?? '';

        $has_positional_parameters = $positional_parameter_1 !== '';

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
        $has_options = (bool) count($options);

        // Foo
        // ───
        $has_list_flag = $positional_parameter_1 === 'foo';
        if($has_list_flag){
            $this->displayFoo();
            return;
        }

        // Version
        // ───────
        $has_version_flag = $this->array_utility->arrayHasValueInsensitive($option_keys,'v') || $this->array_utility->arrayHasValueInsensitive($option_keys,'version') || $positional_parameter_1 === 'version' || $positional_parameter_1 === 'Version';
        if($has_version_flag){
            $this->displayVersion();
            return;
        }

        // Unknown Parameters
        // ──────────────────
        if($has_positional_parameters){
            $this->displayUnknownParameters();
            return;
        }

        // Info
        // ────
        $this->displayInfo();
    }

    public function displayInfo() {
        $this->writer->writeLine('Pith Command Tool 2');

        //$indexCommand = new IndexCommand();
        $indexCommand = $this->container->get('Pith\\Framework\\Plugin\\CommandTool2\\IndexCommand');

        $indexCommand->run();
    }

    public function displayVersion()
    {
        $app = $this->app_retriever->getApp();
        $version_text = $app->info->getVersionText();
        $this->writer->writeLine($version_text);
    }

    public function displayUnknownParameters()
    {
        // Get formatter
        $formatter = $this->formatter;

        // Output
        $this->writer->writeLine($formatter->fg_bright_red . 'Unknown Parameters' . $formatter->reset);
    }

    public function displayFoo()
    {
        $this->writer->writeLine('bar');
    }

}
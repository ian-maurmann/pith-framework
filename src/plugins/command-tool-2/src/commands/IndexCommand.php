<?php

/**
 * Index Command
 * -------------
 *
 * @noinspection PhpMethodNamingConventionInspection
 */


declare(strict_types=1);

namespace Pith\Framework\Plugin\CommandTool2;


/**
 * Class IndexCommand
 */
class IndexCommand
{
    public function __construct()
    {
        // Do nothing for now.
    }

    public function run()
    {
        $artService = new ArtService();

        // Draw logo art
        $artService->drawPithFrameworkLogo();
    }

}
<?php

use Latte\Runtime as LR;

/** source: src/shared-infrastructure/src/shared-theme-pack/green-and-white-theme/green-and-white-layout-view.latte */
final class Template41b4ce71f7 extends Latte\Runtime\Template
{

	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Format -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <!-- Title -->
        <title>';
		echo LR\Filters::escapeHtmlText(($this->global->fn->insertPageTitle)()) /* line 9 */;
		echo '</title>

        <!-- Viewport -->
        <meta name="HandheldFriendly" content="true">
        <meta name="MobileOptimized"  content="width">
        <meta name="viewport"         content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scale=no">

        <!-- Page Description -->
        <meta name="description" content="';
		echo LR\Filters::escapeHtmlAttr(($this->global->fn->insertMetaDescription)()) /* line 17 */;
		echo '">

        <!-- Page Keywords -->
        <meta name="keywords" content="';
		echo LR\Filters::escapeHtmlAttr(($this->global->fn->insertMetaKeywords)()) /* line 20 */;
		echo '">

        ';
		echo LR\Filters::escapeHtmlText(($this->global->fn->insertMetaRobots)(2)) /* line 22 */;
		echo '
        ';
		echo LR\Filters::escapeHtmlText(($this->global->fn->insertResourceFiles)(2)) /* line 23 */;
		echo '
    </head>
    <body>
        <div id="banner-area">
            Banner
            <nav>
                ';
		echo LR\Filters::escapeHtmlText(($this->global->fn->insertPartial)('Pith\\Framework\\SharedInfrastructure\\DemoNavLinksPartialRoute')) /* line 29 */;
		echo '
            </nav>
        </div>
        <div id="content-area">
            <div id="plate">
                <div id="content">
                    ';
		echo LR\Filters::escapeHtmlText(($this->global->fn->insertPage)()) /* line 35 */;
		echo '
                </div>

                <hr/>
            </div>
            <div id="footer">
                ';
		echo LR\Filters::escapeHtmlText(($this->global->fn->insertPartial)('Pith\\Framework\\SharedInfrastructure\\FooterRoute')) /* line 41 */;
		echo '
            </div>
        </div>

    </body>
</html>';
	}
}

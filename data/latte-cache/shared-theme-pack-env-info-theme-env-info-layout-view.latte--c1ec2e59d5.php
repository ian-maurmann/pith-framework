<?php

use Latte\Runtime as LR;

/** source: src/shared-infrastructure/src/shared-theme-pack/env-info-theme/env-info-layout-view.latte */
final class Templatec1ec2e59d5 extends Latte\Runtime\Template
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

        <!-- Using Latte -->

        <!-- Title -->
        <title>';
		echo LR\Filters::escapeHtmlText(($this->global->fn->insertPageTitle)()) /* line 11 */;
		echo '</title>

        <!-- Viewport -->
        <meta name="HandheldFriendly" content="true">
        <meta name="MobileOptimized"  content="width">
        <meta name="viewport"         content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scale=no">

        <!-- Page Description -->
        <meta name="description" content="';
		echo LR\Filters::escapeHtmlAttr(($this->global->fn->insertMetaDescription)()) /* line 19 */;
		echo '">

        <!-- Page Keywords -->
        <meta name="keywords" content="';
		echo LR\Filters::escapeHtmlAttr(($this->global->fn->insertMetaKeywords)()) /* line 22 */;
		echo '">

        ';
		echo LR\Filters::escapeHtmlText(($this->global->fn->insertMetaRobots)(2)) /* line 24 */;
		echo '
        ';
		echo LR\Filters::escapeHtmlText(($this->global->fn->insertResourceFiles)(2)) /* line 25 */;
		echo '
    </head>
    <body>
        <div id="sidebar">
            <nav>
                ';
		echo LR\Filters::escapeHtmlText(($this->global->fn->insertPartial)('Pith\\Framework\\SharedInfrastructure\\EnvInfoSidebarPartialRoute')) /* line 30 */;
		echo '
            </nav>
        </div>
        <div id="main">
            <div id="content">
                ';
		echo LR\Filters::escapeHtmlText(($this->global->fn->insertPage)()) /* line 35 */;
		echo '
            </div>

            <hr/>

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

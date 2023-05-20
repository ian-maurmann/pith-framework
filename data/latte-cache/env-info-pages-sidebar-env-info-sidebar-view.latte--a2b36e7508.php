<?php

use Latte\Runtime as LR;

/** source: src/shared-infrastructure/src/shared-infrastructure-pack/page-flow/env-info-pages/sidebar/env-info-sidebar-view.latte */
final class Templatea2b36e7508 extends Latte\Runtime\Template
{

	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h4>Env Info Pages:</h4>
<ul>
    <li>
        <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH)) /* line 4 */;
		echo '"><i class="fa-solid fa-house"></i> Env Info - Main</a>
    </li>
    <li>
        <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH)) /* line 7 */;
		echo '/server-info"><i class="fa-solid fa-server"></i> Server Info</a>
    </li>
    <li>
        <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH)) /* line 10 */;
		echo '/php-info"><i class="fa-brands fa-php"></i> PHP Info</a>
    </li>
    <li>
        <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH)) /* line 13 */;
		echo '/route-list"><i class="fa-solid fa-right-long"></i> Route List</a>
    </li>
    <li>
        <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH)) /* line 16 */;
		echo '/database-info"><i class="fa-solid fa-database"></i> Database Info</a>
    </li>
</ul>

';
	}
}

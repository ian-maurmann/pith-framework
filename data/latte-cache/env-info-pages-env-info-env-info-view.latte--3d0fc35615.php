<?php

use Latte\Runtime as LR;

/** source: src/shared-infrastructure/src/shared-infrastructure-pack/env-info-pages/env-info/env-info-view.latte */
final class Template3d0fc35615 extends Latte\Runtime\Template
{

	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h3>Env Info</h3>

<ul>
    <li>
        <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH)) /* line 5 */;
		echo '/server-info">Server Info</a>
    </li>
    <li>
        <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH)) /* line 8 */;
		echo '/php-info">PHP Info</a>
    </li>
    <li>
        <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH)) /* line 11 */;
		echo '/route-list">Route List</a>
    </li>
    <li>
        <a href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($PITH_ENV_INFO_PAGES_ROUTE_GROUP_PATH)) /* line 14 */;
		echo '/database-info">Database Info</a>
    </li>
</ul>

';
	}
}

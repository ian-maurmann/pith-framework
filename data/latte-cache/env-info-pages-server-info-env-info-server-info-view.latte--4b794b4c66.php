<?php

use Latte\Runtime as LR;

/** source: src/shared-infrastructure/src/shared-infrastructure-pack/page-flow/env-info-pages/server-info/env-info-server-info-view.latte */
final class Template4b794b4c66 extends Latte\Runtime\Template
{

	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h3>Server Info</h3>

<blockquote cite="https://www.php.net/manual/en/reserved.variables.server.php">
    <i>
        <b>Note:</b> When running PHP on the command line most of these entries will not be available or have any meaning.
    </i>
    -- <a href="https://www.php.net/manual/en/reserved.variables.server.php" target="_blank">PHP Manual - $_SERVER <i class="fa4 fa4-external-link-square" aria-hidden="true"></i></a>
</blockquote>


<table data-table-style="server-info">
    <thead>
        <tr>
            <th colspan="2">$_SERVER information</th>
        </tr>
        <tr>
            <th>Name:</th>
            <th>Value:</th>
        </tr>
    </thead>
    <tbody>
';
		foreach ($iterator = $ʟ_it = new Latte\Essential\CachingIterator($server_information, $ʟ_it ?? null) as $server_info_element_name => $server_info_element_value) /* line 22 */ {
			echo '        <tr>
            <th>';
			echo LR\Filters::escapeHtmlText($server_info_element_name) /* line 24 */;
			echo '</th>
            <td>';
			echo LR\Filters::escapeHtmlText($server_info_element_value) /* line 25 */;
			echo '</td>
        </tr>
';
		}
		if ($iterator->isEmpty()) /* line 27 */ {
			echo '        <tr>
            <td colspan="2"><i>Empty</i></td>
        </tr>
';

		}
		$iterator = $ʟ_it = $ʟ_it->getParent();

		echo '    </tbody>
</table>';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['server_info_element_name' => '22', 'server_info_element_value' => '22'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}

<?php

use Latte\Runtime as LR;

/** source: src/shared-infrastructure/src/shared-infrastructure-pack/env-info-pages/db-info/env-info-database-info.latte */
final class Templated398a4fefc extends Latte\Runtime\Template
{

	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo 'Connection Info:
<br/>
<table data-table-style="route-list-info">
    <tbody>
    <tr>
        <th>DSN</th>
        <td>';
		echo LR\Filters::escapeHtmlText($dsn) /* line 7 */;
		echo '</td>
    </tr>
    <tr>
        <th>Migrations DB Name</th>
        <td>';
		echo LR\Filters::escapeHtmlText($migrations_database_name) /* line 11 */;
		echo '</td>
    </tr>
    <tr>
        <th>Migrations DB Host</th>
        <td>';
		echo LR\Filters::escapeHtmlText($migrations_database_host) /* line 15 */;
		echo '</td>
    </tr>
    <tr>
        <th>Migrations DB Driver</th>
        <td>';
		echo LR\Filters::escapeHtmlText($migrations_database_driver) /* line 19 */;
		echo '</td>
    </tr>
    </tbody>
</table>
<br/>
Try to fetch the test quotes:<br/>
<br/>
<table data-table-style="route-list-info">
    <thead>
    <tr>
        <th colspan="2">Test Quotes</th>
    </tr>
    <tr>
        <th>Quote ID</th>
        <th>Quote</th>
    </tr>
    </thead>
    <tbody>
';
		foreach ($iterator = $ʟ_it = new Latte\Essential\CachingIterator($quote_results, $ʟ_it ?? null) as $quote_result) /* line 37 */ {
			echo '        <tr>
            <td>';
			echo LR\Filters::escapeHtmlText($quote_result['quote_id']) /* line 39 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($quote_result['quote']) /* line 40 */;
			echo '</td>
        </tr>
';
		}
		if ($iterator->isEmpty()) /* line 42 */ {
			echo '        <tr>
            <td colspan="2"><i>No routes found.</i></td>
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
			foreach (array_intersect_key(['quote_result' => '37'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}

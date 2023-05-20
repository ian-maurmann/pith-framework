<?php

use Latte\Runtime as LR;

/** source: src/shared-infrastructure/src/shared-infrastructure-pack/env-info-pages/route-info/env-info-route-list-view.latte */
final class Template336c569d15 extends Latte\Runtime\Template
{

	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo '<h3>Route List</h3>

<table data-table-style="route-list-info">
    <thead>
    <tr>
        <th colspan="4">Route List</th>
    </tr>
    <tr>
        <th>Type</th>
        <th>Method</th>
        <th>Path</th>
        <th>Route Namespace</th>
    </tr>
    </thead>
    <tbody>
';
		foreach ($iterator = $ʟ_it = new Latte\Essential\CachingIterator($routes, $ʟ_it ?? null) as $route) /* line 16 */ {
			echo '        <tr>
            <td>';
			echo LR\Filters::escapeHtmlText($route[0]) /* line 18 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($route[1]) /* line 19 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($route[2]) /* line 20 */;
			echo '</td>
            <td>';
			echo LR\Filters::escapeHtmlText($route[3]) /* line 21 */;
			echo '</td>
        </tr>
';
		}
		if ($iterator->isEmpty()) /* line 23 */ {
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
			foreach (array_intersect_key(['route' => '16'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}

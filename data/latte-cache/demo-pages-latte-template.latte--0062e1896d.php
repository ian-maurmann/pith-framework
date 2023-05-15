<?php

use Latte\Runtime as LR;

/** source: src/shared-infrastructure/src/shared-infrastructure-pack/demo-pages/latte/template.latte */
final class Template0062e1896d extends Latte\Runtime\Template
{

	public function main(array $ʟ_args): void
	{
		extract($ʟ_args);
		unset($ʟ_args);

		echo 'This view is using Latte.

<p>Hello, ';
		echo LR\Filters::escapeHtmlText(($this->filters->upper)('World!')) /* line 3 */;
		echo '</p>

<ul>
';
		foreach ($iterator = $ʟ_it = new Latte\Essential\CachingIterator($quote_results, $ʟ_it ?? null) as $quote_result) /* line 6 */ {
			echo '    <li>';
			echo LR\Filters::escapeHtmlText($quote_result['quote']) /* line 7 */;
			echo '</li>
';
		}
		if ($iterator->isEmpty()) /* line 8 */ {
			echo '    <li><em>Sorry, no quotes in this list</em></li>
';

		}
		$iterator = $ʟ_it = $ʟ_it->getParent();

		echo '</ul>';
	}


	public function prepare(): array
	{
		extract($this->params);

		if (!$this->getReferringTemplate() || $this->getReferenceType() === 'extends') {
			foreach (array_intersect_key(['quote_result' => '6'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		return get_defined_vars();
	}
}

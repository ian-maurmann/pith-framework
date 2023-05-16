<?php

use Latte\Runtime as LR;

/** source: src/shared-infrastructure/src/shared-infrastructure-pack/demo-pages/demonstrate-libraries-work/demonstrate-fontsheets.latte */
final class Template39d346d169 extends Latte\Runtime\Template
{

	public function main(array $ʟ_args): void
	{
		echo '
<section>
    <h3>
        Show that included fontsheets are working:
    </h3>

    <hr/>

    <ul>
        <li style="font-family: \'JetBrains Mono NL\',Consolas,monaco,monospace;">
            JetBrains Mono NL - The quick brown fox jumped over the lazy dog. Oh how I quickly daft over leaping jumping zebras! 01234-56789.
        </li>
        <li style="font-family: \'JetBrains Mono NL\',Consolas,monaco,monospace;">
            <i>JetBrains Mono NL - The quick brown fox jumped over the lazy dog. Oh how I quickly daft over leaping jumping zebras! 01234-56789.</i>
        </li>
        <li style="font-family: \'JetBrains Mono NL\',Consolas,monaco,monospace;">
            <b>JetBrains Mono NL - The quick brown fox jumped over the lazy dog. Oh how I quickly daft over leaping jumping zebras! 01234-56789.</b>
        </li>
        <li style="font-family: \'JetBrains Mono NL\',Consolas,monaco,monospace;">
            <b><i>JetBrains Mono NL - The quick brown fox jumped over the lazy dog. Oh how I quickly daft over leaping jumping zebras! 01234-56789.</i></b>
        </li>
    </ul>

    <hr/>
    
</section>';
	}
}

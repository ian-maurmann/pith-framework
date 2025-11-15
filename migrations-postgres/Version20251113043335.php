<?php

/**
 * Migration to populate test quotes table
 * ---------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class name for migration is ok.
 * @noinspection PhpMethodNamingConventionInspection - Short method names are ok.
 * @noinspection PhpUnused - Used by database migration tool
 * @noinspection PhpMissingParentCallCommonInspection - Meant to not call parent, for this use-case.
 */

declare(strict_types=1);

namespace Pith\Framework\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration
 */
final class Version20251113043335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Populate table pith_test_quotes, with some quotes for testing.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "
            INSERT INTO pith_test_quotes 
                (quote_id, quote) 
            VALUES 
                (1, 'Hello, World!'),
                (2, 'What hath God wrought?'),
                (3, 'The quick brown fox jumps over the lazy dog.'),
                (4, 'Garbage in, garbage out.'),
                (5, 'Eureka! Eureka!'),
                (6, 'Dear Mr. Edison, ... For myself, I can only say that I am astonished and, somewhat, terrified at the results of this evening''s experiments. Astonished at the wonderful power you have developed, and terrified at the thought that so much hideous and bad music may be put on record forever.')
            "
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM pith_test_quotes WHERE quote_id IN (1,2,3,4,5,6)');
    }
}

<?php

/**
 * Migration to populate test_quotes table
 * ---------------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection   - Long class name is ok.
 * @noinspection PhpMissingParentCallCommonInspection - Parent method calls are not needed.
 * @noinspection PhpMethodNamingConventionInspection  - Short method names are ok.
 * @noinspection PhpUnused                            - Ignore.
 */

declare(strict_types=1);

namespace Pith\Framework\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration
 */
final class Version20230510000814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Populate `pith_test_quotes` table with some quotes for testing.';
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
                (4, 'Garbage in, garbage out.')
            "
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM pith_test_quotes WHERE quote_id IN (1,2,3,4)');
    }
}

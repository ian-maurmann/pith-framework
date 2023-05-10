<?php

declare(strict_types=1);

namespace Pith\Framework\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230510000814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Populate test_quotes with some quotes for testing.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql(
            '
            INSERT INTO test_quotes (quote_id, quote) VALUES (1, "Hello, World!")
            '
        );

        $this->addSql(
            '
            INSERT INTO test_quotes (quote_id, quote) VALUES (2, "What hath God wrought?")
            '
        );

        $this->addSql(
            '
            INSERT INTO test_quotes (quote_id, quote) VALUES (3, "The quick brown fox jumps over the lazy dog.")
            '
        );

        $this->addSql(
            '
            INSERT INTO test_quotes (quote_id, quote) VALUES (4, "Garbage in, garbage out.")
            '
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DELETE FROM test_quotes WHERE quote_id IN (1,2,3,4)');
    }
}

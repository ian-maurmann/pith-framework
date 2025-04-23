<?php

/**
 * Migration to add test_quotes table
 * ----------------------------------
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
final class Version20230509232040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `pith_test_quotes`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE pith_test_quotes (
                quote_id INT AUTO_INCREMENT NOT NULL, 
                quote VARCHAR(191) DEFAULT NULL, 
                PRIMARY KEY(quote_id)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE pith_test_quotes');
    }
}

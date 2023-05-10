<?php

declare(strict_types=1);

namespace Pith\Framework\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509232040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add table for test quotes';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('
            CREATE TABLE test_quotes (
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
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DROP TABLE test_quotes');
    }
}

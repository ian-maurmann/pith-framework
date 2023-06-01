<?php

/**
 * Migration to add user table
 * ---------------------------
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
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601002528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `users`.';
    }

    public function up(Schema $schema): void
    {
        // SideNote:
        //     check_char would be VARCHAR(4) for 1 char in utf8mb4, but, "basic Latin
        //         letters, numbers and punctuation only use one byte", so using CHAR(1) here.

        $this->addSql('
            CREATE TABLE `users` (
                `user_id` INT AUTO_INCREMENT NOT NULL, 
                `check_char` CHAR(1) DEFAULT NULL,
                `datetime_created` DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(`user_id`)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE IF EXISTS `users`');
    }
}

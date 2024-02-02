<?php

/**
 * Migration to add `user_account_info` table
 * ------------------------------------------
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
final class Version20230622220353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `user_account_info`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `user_account_info` (
                `user_id` INT UNIQUE NOT NULL, 
                `user_date_of_birth` DATETIME DEFAULT NULL,
                PRIMARY KEY (`user_id`),
                CONSTRAINT `user_account_info_fk_user_id` 
                    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `user_account_info`');
    }
}

<?php

/**
 * Migration to add `access_level_webmaster_users` table
 * -----------------------------------------------------
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
final class Version20230719210918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `access_level_webmaster_users`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `access_level_webmaster_users` (
                `access_level_linker_id` INT AUTO_INCREMENT UNIQUE NOT NULL, 
                `user_id` INT UNIQUE NOT NULL, 
                PRIMARY KEY (`access_level_linker_id`),
                CONSTRAINT `access_level_webmaster_users_fk_user_id` 
                    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `access_level_webmaster_users`');
    }
}

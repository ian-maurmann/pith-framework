<?php

/**
 * Migration to create user access levels table
 * ---------------------------------------
 *
 * @noinspection PhpUnused - Migration, used by migration tool.
 * @noinspection PhpClassNamingConventionInspection - Long class name is ok.
 * @noinspection PhpMissingParentCallCommonInspection - Parent calls not needed here.
 * @noinspection PhpMethodNamingConventionInspection - Short method names are ok.
 */


declare(strict_types=1);

namespace Pith\Framework\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration
 */
final class Version20250331061441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `pith_user_access_levels`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `pith_user_access_levels` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT UNIQUE NOT NULL,
                `user_id` BIGINT UNSIGNED NOT NULL,
                `access_level_id` BIGINT UNSIGNED NOT NULL,
                PRIMARY KEY(`id`),
                CONSTRAINT `pith_user_access_levels_fk_user_id` 
                    FOREIGN KEY (`user_id`) REFERENCES `pith_users`(`user_id`),
                CONSTRAINT `pith_user_access_levels_fk_access_level_id` 
                    FOREIGN KEY (`access_level_id`) REFERENCES `pith_access_levels`(`access_level_id`)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `pith_user_access_levels`');
    }
}

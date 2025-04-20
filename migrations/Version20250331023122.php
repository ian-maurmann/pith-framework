<?php

/**
 * Migration to create access levels table
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
final class Version20250331023122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `pith_access_levels`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `pith_access_levels` (
                `access_level_id` BIGINT UNSIGNED AUTO_INCREMENT UNIQUE NOT NULL,
                `access_level_name` VARCHAR(191) UNIQUE, 
                PRIMARY KEY(`access_level_id`)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `pith_access_levels`');
    }
}

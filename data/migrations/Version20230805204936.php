<?php

/**
 * Migration to add `unique_impressions` table
 * ------------------------------------
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
final class Version20230805204936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `unique_impressions`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `unique_impressions` (
                `unique_impression_id` BIGINT AUTO_INCREMENT UNIQUE NOT NULL, 
                `date` DATETIME NOT NULL,
                `ip` VARCHAR(191) NOT NULL,
                `user_id` INT NOT NULL,
                `user_agent_string` VARCHAR(191) NOT NULL,
                PRIMARY KEY (`unique_impression_id`),
                UNIQUE KEY `unique_impressions_uk_all` (`date`,`ip`, `user_id`, `user_agent_string`)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `uniques`');
    }
}

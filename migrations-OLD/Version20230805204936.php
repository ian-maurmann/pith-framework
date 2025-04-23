<?php

/**
 * Migration to add `unique_daily_views` table
 * -------------------------------------------
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
        return 'Create new table `unique_daily_views`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `unique_daily_views` (
                `unique_daily_view_id` BIGINT AUTO_INCREMENT UNIQUE NOT NULL, 
                `unique_weekly_view_id` BIGINT DEFAULT NULL, 
                `unique_monthly_view_id` BIGINT DEFAULT NULL, 
                `unique_actor_id` BIGINT DEFAULT NULL, 
                `date_as_string` VARCHAR(10) NOT NULL,
                `ip` VARCHAR(191) NOT NULL,
                `user_id` INT NOT NULL,
                `user_agent_string` VARCHAR(191) NOT NULL,
                PRIMARY KEY (`unique_daily_view_id`),
                UNIQUE KEY `unique_daily_views_uk_identifiers` (`date_as_string`,`ip`, `user_id`, `user_agent_string`)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `unique_daily_views`');
    }
}

<?php

/**
 * Migration to add `impressions` table
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
final class Version20230803233822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `impressions`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `impressions` (
                `impression_id` BIGINT AUTO_INCREMENT UNIQUE NOT NULL, 
                `time` DATETIME NOT NULL,
                `http_method` VARCHAR(9) NOT NULL,
                `uri` VARCHAR(191) NOT NULL,
                `port` VARCHAR(191) NOT NULL,
                `access_level` VARCHAR(191) NOT NULL,
                `is_allowed` TINYINT(1) NOT NULL,
                `ip` VARCHAR(191) NOT NULL,
                `session_id` VARCHAR(191) DEFAULT NULL,
                `is_logged_user` TINYINT(1) NOT NULL,
                `user_id` INT DEFAULT NULL,
                `user_agent_string` VARCHAR(191) DEFAULT NULL,
                `ch_ua` VARCHAR(191) DEFAULT NULL,
                `ch_ua_platform` VARCHAR(191) DEFAULT NULL,
                `ch_ua_platform_version` VARCHAR(191) DEFAULT NULL,
                `ch_ua_mobile` VARCHAR(191) DEFAULT NULL,
                `ch_ua_model` VARCHAR(191) DEFAULT NULL,
                `ch_ua_architecture` VARCHAR(191) DEFAULT NULL,
                `ch_ua_bitness` VARCHAR(191) DEFAULT NULL,
                `accept_language` VARCHAR(191) DEFAULT NULL,
                `referer` VARCHAR(191) DEFAULT NULL,
                `ch_downlink` VARCHAR(191) DEFAULT NULL,
                `ch_viewport_width` VARCHAR(191) DEFAULT NULL,
                `ch_prefers_color_scheme` VARCHAR(191) DEFAULT NULL,
                PRIMARY KEY (`impression_id`)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `impressions`');
    }
}

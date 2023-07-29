<?php

/**
 * Migration to add `queue_impression_log_loading` table
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
final class Version20230729004211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `queue_impression_log_loading`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `queue_impression_log_loading` (
                `in_queue_id` BIGINT AUTO_INCREMENT UNIQUE NOT NULL, 
                `log_file_name` VARCHAR(50) NOT NULL,
                `datetime_start_loading` DATETIME DEFAULT NULL,
                `datetime_done_loading` DATETIME DEFAULT NULL,
                PRIMARY KEY (`in_queue_id`)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `queue_impression_log_loading`');
    }
}

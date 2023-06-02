<?php

/**
 * Migration to add user_email_addresses table
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
final class Version20230602042618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `user_email_addresses`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `user_email_addresses` (
                `email_address_id` INT AUTO_INCREMENT UNIQUE NOT NULL, 
                `user_id` INT NOT NULL,
                `email_address` VARCHAR(191) NOT NULL,
                `datetime_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `datetime_verified` DATETIME DEFAULT NULL,
                PRIMARY KEY(`email_address_id`),
                FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)                
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `user_email_addresses`');
    }
}

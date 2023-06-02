<?php

/**
 * Migration to add user_login_usernames table
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
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601193239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `user_login_usernames`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `user_login_usernames` (
                `username_id` INT AUTO_INCREMENT NOT NULL, 
                `user_id` INT,
                `username` VARCHAR(191) DEFAULT NULL, 
                `username_normalized` VARCHAR(191) DEFAULT NULL, 
                `datetime_created` DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(`username_id`),
                FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)                
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `user_login_usernames`');
    }
}

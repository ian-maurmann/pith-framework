<?php


/**
 * Migration to add `user_creation_queue` table
 * --------------------------------------------
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
final class Version20230620210545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `user_creation_queue`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `user_creation_queue` (
                `user_creation_queue_id` INT AUTO_INCREMENT UNIQUE NOT NULL, 
                `username` VARCHAR(191) NOT NULL, 
                `username_lower` VARCHAR(191) NOT NULL, 
                `email_address` VARCHAR(191) NOT NULL,
                `datetime_birth_date` DATETIME NOT NULL,
                `password_hash` VARCHAR(191) NOT NULL,
                `datetime_queued` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `datetime_user_created` DATETIME DEFAULT NULL,
                `created_user_id` INT DEFAULT NULL,
                `datetime_username_added` DATETIME DEFAULT NULL,
                `created_username_id` INT DEFAULT NULL,
                `datetime_email_address_added` DATETIME DEFAULT NULL,
                `created_email_address_id` INT DEFAULT NULL,
                `datetime_password_added` DATETIME DEFAULT NULL,
                `created_password_id` INT DEFAULT NULL,
                `datetime_login_credential_added` DATETIME DEFAULT NULL,
                `created_login_credential_id` INT DEFAULT NULL,
                PRIMARY KEY (`user_creation_queue_id`),
                CONSTRAINT `user_creation_queue_fk_created_user_id` 
                    FOREIGN KEY (`created_user_id`) REFERENCES `users`(`user_id`),
                CONSTRAINT `user_creation_queue_fk_created_username_id`
                    FOREIGN KEY (`created_username_id`) REFERENCES `user_login_usernames`(`username_id`),
                CONSTRAINT `user_creation_queue_fk_created_password_id`
                    FOREIGN KEY (`created_password_id`) REFERENCES `user_login_passwords`(`password_id`),
                CONSTRAINT `user_creation_queue_fk_created_email_address_id`
                    FOREIGN KEY (`created_email_address_id`) REFERENCES `user_email_addresses`(`email_address_id`),
                CONSTRAINT `user_creation_queue_fk_created_login_credential_id`
                    FOREIGN KEY (`created_login_credential_id`) REFERENCES `user_login_credentials`(`login_credential_id`)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `user_creation_queue`');
    }
}

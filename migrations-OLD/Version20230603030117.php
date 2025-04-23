<?php

/**
 * Migration to add `user_login_credentials` table
 * -----------------------------------------------
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
final class Version20230603030117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `user_login_credentials`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `user_login_credentials` (
                `login_credential_id` INT AUTO_INCREMENT UNIQUE NOT NULL, 
                `user_id` INT NOT NULL,
                `username_id` INT DEFAULT NULL,
                `password_id` INT NOT NULL,
                `email_address_id` INT DEFAULT NULL,
                `datetime_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `datetime_first_used` DATETIME DEFAULT NULL,
                PRIMARY KEY (`login_credential_id`),
                CONSTRAINT `user_login_credentials_fk_user_id` 
                    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
                CONSTRAINT `user_login_credentials_fk_username_id`
                    FOREIGN KEY (`username_id`) REFERENCES `user_login_usernames`(`username_id`),
                CONSTRAINT `user_login_credentials_fk_password_id`
                    FOREIGN KEY (`password_id`) REFERENCES `user_login_passwords`(`password_id`),
                CONSTRAINT `user_login_credentials_fk_email_address_id`
                    FOREIGN KEY (`email_address_id`) REFERENCES `user_email_addresses`(`email_address_id`)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `user_login_credentials`');
    }
}

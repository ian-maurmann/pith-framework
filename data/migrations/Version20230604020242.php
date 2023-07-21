<?php

/**
 * Migration to add `logins` table
 * -------------------------------
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
final class Version20230604020242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `logins`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `logins` (
                `login_id` BIGINT AUTO_INCREMENT UNIQUE NOT NULL, 
                `user_id` INT DEFAULT NULL,
                `login_credential_id` INT DEFAULT NULL,
                `datetime_logged_id` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`login_id`),
                CONSTRAINT `logins_fk_user_id` 
                    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
                CONSTRAINT `logins_fk_login_credential_id`
                    FOREIGN KEY (`login_credential_id`) REFERENCES `user_login_credentials`(`login_credential_id`)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `logins`');
    }
}

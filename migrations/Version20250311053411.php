<?php

/**
 * Migration to create user table
 * ------------------------------
 *
 * @noinspection PhpClassNamingConventionInspection - Long class name for migration is ok.
 * @noinspection PhpMethodNamingConventionInspection - Short method names are ok.
 * @noinspection PhpUnused - Used by database migration tool
 * @noinspection PhpMissingParentCallCommonInspection - Meant to not call parent, for this use-case.
 */

declare(strict_types=1);

namespace Pith\Framework\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/** @noinspection PhpUnused */


/**
 * Migration
 */
final class Version20250311053411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `users`.';
    }

    public function up(Schema $schema): void
    {
        // Side Notes:
        // - `check_char` would be VARCHAR(4) for 1 char in utf8mb4, but, "basic Latin
        //       letters, numbers and punctuation only use one byte", so using CHAR(1) here.
        // - `user_ulid` would be VARCHAR(104) for 26 chars in utf8mb4, but, "basic Latin
        //       letters, numbers and punctuation only use one byte", so using CHAR(26) here.
        // - Making `username` `username_lower` `primary_email_address` be "UNIQUE" but not "NOT NULL",
        //       because we'll be migrating to this from systems that rely on just email login,
        //       and also systems with usernames and non-unique emails addresses.

        $this->addSql('
            CREATE TABLE `users` (
                `user_id` BIGINT UNSIGNED AUTO_INCREMENT UNIQUE NOT NULL,
                `user_ulid` CHAR(26) UNIQUE NOT NULL,
                `check_char` CHAR(1) NOT NULL,
                `username` VARCHAR(191) UNIQUE, 
                `username_lower` VARCHAR(191) UNIQUE, 
                `primary_email_address` VARCHAR(191) UNIQUE,
                `primary_email_address_is_validated` TINYINT(1) NOT NULL DEFAULT 0,
                `password_hash` VARCHAR(191) NOT NULL,
                `datetime_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(`user_id`)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `users`');
    }
}

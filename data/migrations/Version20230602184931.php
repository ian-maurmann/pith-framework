<?php

/**
 * Migration to add `user_telephone_numbers` table
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
final class Version20230602184931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table `user_telephone_numbers`.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `user_telephone_numbers` (
                `telephone_number_id` INT AUTO_INCREMENT UNIQUE NOT NULL, 
                `user_id` INT NOT NULL,
                `telephone_country_alpha2` CHAR(2) DEFAULT NULL,
                `telephone_number_raw` VARCHAR(20) DEFAULT NULL,
                `telephone_number_e164` VARCHAR(18) NOT NULL,
                `telephone_number_international` VARCHAR(20) DEFAULT NULL,
                `telephone_number_national` VARCHAR(20) DEFAULT NULL,
                `telephone_extension` VARCHAR(6) DEFAULT NULL,
                `datetime_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `datetime_verified` DATETIME DEFAULT NULL,
                `datetime_last_reasserted` DATETIME DEFAULT NULL,
                PRIMARY KEY(`telephone_number_id`),
                CONSTRAINT `user_telephone_numbers_fk_user_id` 
                    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)                
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci
            '
        );



        // SideNote on phone extensions:
        //     "The following extension configuration is not recommended:
        //      *711 *711x Extensions starting with these digits will go to the TTY Relay Center;
        //      *411 *411x Extensions starting with these digits will go to Information;
        //      *611 *611x Extensions starting with these digits will report a problem with telephone service (landline service);
        //      *911 *911x Extensions starting with these digits will got to Emergency Call Centers if enabled in customer's account.
        //      988 is reserved for the Suicide Prevention Hotline.
        //          source: https://support.onsip.com/hc/en-us/articles/204190534-Best-Practices-for-Extensions
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `user_telephone_numbers`');

    }
}

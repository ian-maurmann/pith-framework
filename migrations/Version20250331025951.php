<?php

/**
 * Migration to populate pith_access_levels table
 * ---------------------------------------
 *
 * @noinspection PhpUnused - Migration, used by migration tool.
 * @noinspection PhpClassNamingConventionInspection - Long class name is ok.
 * @noinspection PhpMissingParentCallCommonInspection - Parent calls not needed here.
 * @noinspection PhpMethodNamingConventionInspection - Short method names are ok.
 */

declare(strict_types=1);

namespace Pith\Framework\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration
 */
final class Version20250331025951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Populate `pith_access_levels` table.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (100, "none")
            '
        );

        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (101, "dev-ip")
            '
        );

        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (102, "cron-ip")
            '
        );

        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (103, "task")
            '
        );

        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (200, "world")
            '
        );



        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (201, "perform-user-login")
            '
        );



        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (300, "user")
            '
        );

        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (301, "perform-user-logout")
            '
        );

        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (302, "logout")
            '
        );

        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (400, "internal")
            '
        );

        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (500, "moderator")
            '
        );

        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (600, "dev")
            '
        );

        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (700, "admin")
            '
        );

        $this->addSql(
            '
            INSERT INTO pith_access_levels (access_level_id, access_level_name) VALUES (800, "webmaster")
            '
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM pith_access_levels WHERE access_level_id IN (100, 101, 102, 103, 200, 201, 300, 301, 302, 400, 500, 600, 700, 800)');

    }
}

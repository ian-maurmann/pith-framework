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
            "
            INSERT INTO pith_access_levels 
                (access_level_id, access_level_name) 
            VALUES 
                (100, 'none'),
                (101, 'dev-ip'),
                (102, 'cron-ip'),
                (103, 'task'),
                (200, 'world'),
                (201, 'perform-user-login'),
                (300, 'user'),
                (301, 'perform-user-logout'),
                (302, 'logout'),
                (400, 'internal'),
                (500, 'moderator'),
                (600, 'dev'),
                (700, 'admin'),
                (800, 'webmaster')
            "
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM pith_access_levels WHERE access_level_id IN (100, 101, 102, 103, 200, 201, 300, 301, 302, 400, 500, 600, 700, 800)');
    }
}

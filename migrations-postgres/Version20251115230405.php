<?php

/**
 * Migration to populate roles table
 * ---------------------------------
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
final class Version20251115230405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Populate table pith_roles, with roles.';
    }

    public function up(Schema $schema): void
    {
        // General hierarchy:
        // identity, user, internal, moderator, admin

        $this->addSql(
            /** @lang PostgreSQL */
            "
            INSERT INTO pith_roles 
                (role_id, role_name) 
            VALUES 
                (1000, 'none'),
                
                (2000, 'sub-identity'),
                (3000, 'identity'),
                
                (4000, 'super-identity'),
                (4001, 'dev-ip'),
                (4002, 'cron-ip'),
                (4003, 'task'),
                
                (5000, 'sub-user'),
                (6000, 'user'),
                (7000, 'super-user'),
                
                (8000, 'sub-internal'),
                
                (9000, 'internal'),
                (9001, 'writer'),
                
                (10000, 'super-internal'),
                
                (11000, 'sub-moderator'),
                (11001, 'copy-editor'),
                
                (12000, 'moderator'),
                (12001, 'section-editor'),
                
                (13000, 'super-moderator'),
                (13001, 'managing-editor'),
                
                (14000, 'sub-admin'),
                (14001, 'editor-in-chief'),
                (14002, 'deputy-editor-in-chief'),
                
                (15000, 'admin'),
                (15001, 'publisher'),
                
                (16000, 'super-admin'),
                (16001, 'webmaster'),
                (16002, 'postmaster'),
                (16003, 'hostmaster'),
                (16004, 'dev-admin')
            "
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            /** @lang PostgreSQL */
            'DELETE FROM pith_roles WHERE role_id IN 
            (
            1000,
            2000,
            3000,
            4000,
            4001,
            4002,
            4003,
            5000,
            6000,
            7000,
            8000,
            9000,
            9001,
            10000,
            11000,
            11001,
            12000,
            12001,
            13000,
            13001,
            14000,
            14001,
            14002,
            15000,
            15001,
            16000,
            16001,
            16002,
            16003,
            16004
            )
        ');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219011252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('UPDATE os_flag SET major_version=CONCAT(major_version, CONCAT(\'.\', minor_version));');
        $this->addSql('ALTER TABLE os_flag DROP minor_version');
        $this->addSql('ALTER TABLE os_flag RENAME COLUMN major_version TO version');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE os_flag ADD minor_version VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE os_flag RENAME COLUMN version TO major_version');
    }
}

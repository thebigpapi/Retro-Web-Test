<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240404235842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE os_flag ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT \'2019-04-30 00:00:00\'');
        $this->addSql('ALTER TABLE os_flag ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE os_flag ADD sort INT NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE os_flag ALTER sort DROP DEFAULT');
        $this->addSql('ALTER TABLE os_flag RENAME COLUMN version TO file_name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE os_flag RENAME COLUMN file_name TO version');
    }
}

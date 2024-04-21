<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240421212628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chip ADD misc_specs JSONB');
        $this->addSql('UPDATE chip SET misc_specs=ec.misc_specs FROM expansion_chip ec WHERE chip.id=ec.id');
        $this->addSql('ALTER TABLE expansion_chip DROP misc_specs');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expansion_chip ADD misc_specs JSONB NOT NULL');
        $this->addSql('ALTER TABLE chip DROP misc_specs');
        $this->addSql('ALTER TABLE chip ALTER type_id DROP NOT NULL');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108231915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_card_alias ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE expansion_card_bios ADD file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_card_bios ADD note VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_card_bios ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE expansion_card ADD last_edited TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expansion_card_alias DROP name');
        $this->addSql('ALTER TABLE expansion_card_bios DROP file_name');
        $this->addSql('ALTER TABLE expansion_card_bios DROP note');
        $this->addSql('ALTER TABLE expansion_card_bios DROP updated_at');
        $this->addSql('ALTER TABLE expansion_card DROP last_edited');
    }
}

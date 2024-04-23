<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240121204622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_card ADD width SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_card ADD height SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_card ADD length SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_card ADD slot_count SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_card ALTER misc_specs DROP DEFAULT');
        $this->addSql('ALTER TABLE expansion_card ALTER misc_specs SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expansion_card DROP width');
        $this->addSql('ALTER TABLE expansion_card DROP height');
        $this->addSql('ALTER TABLE expansion_card DROP length');
        $this->addSql('ALTER TABLE expansion_card DROP slot_count');
        $this->addSql('ALTER TABLE expansion_card ALTER misc_specs SET DEFAULT \'[]\'');
        $this->addSql('ALTER TABLE expansion_card ALTER misc_specs DROP NOT NULL');
    }
}

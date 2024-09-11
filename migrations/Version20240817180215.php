<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240817180215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_chip_bios DROP CONSTRAINT fk_361b7cbf79a869a1');
        $this->addSql('DROP INDEX idx_361b7cbf79a869a1');
        $this->addSql('ALTER TABLE expansion_chip_bios RENAME COLUMN expansion_chip_id TO chip_id');
        $this->addSql('ALTER TABLE expansion_chip_bios ADD CONSTRAINT FK_361B7CBFA588ADB3 FOREIGN KEY (chip_id) REFERENCES chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_361B7CBFA588ADB3 ON expansion_chip_bios (chip_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expansion_chip_bios DROP CONSTRAINT FK_361B7CBFA588ADB3');
        $this->addSql('DROP INDEX IDX_361B7CBFA588ADB3');
        $this->addSql('ALTER TABLE expansion_chip_bios RENAME COLUMN chip_id TO expansion_chip_id');
        $this->addSql('ALTER TABLE expansion_chip_bios ADD CONSTRAINT fk_361b7cbf79a869a1 FOREIGN KEY (expansion_chip_id) REFERENCES expansion_chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_361b7cbf79a869a1 ON expansion_chip_bios (expansion_chip_id)');
    }
}

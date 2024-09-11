<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240421210931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expansion_card_chip (expansion_card_id INT NOT NULL, chip_id INT NOT NULL, PRIMARY KEY(expansion_card_id, chip_id))');
        $this->addSql('CREATE INDEX IDX_A2E7144396EC5E32 ON expansion_card_chip (expansion_card_id)');
        $this->addSql('CREATE INDEX IDX_A2E71443A588ADB3 ON expansion_card_chip (chip_id)');
        $this->addSql('ALTER TABLE expansion_card_chip ADD CONSTRAINT FK_A2E7144396EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_chip ADD CONSTRAINT FK_A2E71443A588ADB3 FOREIGN KEY (chip_id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_expansion_chip DROP CONSTRAINT fk_3b8c114579a869a1');
        $this->addSql('ALTER TABLE expansion_card_expansion_chip DROP CONSTRAINT fk_3b8c114596ec5e32');
        $this->addSql('INSERT INTO expansion_card_chip (SELECT expansion_card_id, expansion_chip_id FROM expansion_card_expansion_chip)');
        $this->addSql('DROP TABLE expansion_card_expansion_chip');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE expansion_card_expansion_chip (expansion_card_id INT NOT NULL, expansion_chip_id INT NOT NULL, PRIMARY KEY(expansion_card_id, expansion_chip_id))');
        $this->addSql('CREATE INDEX idx_3b8c114596ec5e32 ON expansion_card_expansion_chip (expansion_card_id)');
        $this->addSql('CREATE INDEX idx_3b8c114579a869a1 ON expansion_card_expansion_chip (expansion_chip_id)');
        $this->addSql('ALTER TABLE expansion_card_expansion_chip ADD CONSTRAINT fk_3b8c114579a869a1 FOREIGN KEY (expansion_chip_id) REFERENCES expansion_chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_expansion_chip ADD CONSTRAINT fk_3b8c114596ec5e32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_chip DROP CONSTRAINT FK_A2E7144396EC5E32');
        $this->addSql('ALTER TABLE expansion_card_chip DROP CONSTRAINT FK_A2E71443A588ADB3');
        $this->addSql('DROP TABLE expansion_card_chip');
    }
}

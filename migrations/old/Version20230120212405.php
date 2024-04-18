<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120212405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pci_dev DROP CONSTRAINT fk_161a507e36f0f0c7');
        $this->addSql('ALTER TABLE pci_dev DROP CONSTRAINT fk_161a507e79a869a1');
        $this->addSql('DROP INDEX idx_161a507e79a869a1');
        $this->addSql('DROP INDEX idx_161a507e36f0f0c7');
        $this->addSql('ALTER TABLE pci_dev ADD chip_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pci_dev DROP chipset_part_id');
        $this->addSql('ALTER TABLE pci_dev DROP expansion_chip_id');
        $this->addSql('ALTER TABLE pci_dev ADD CONSTRAINT FK_161A507EA588ADB3 FOREIGN KEY (chip_id) REFERENCES chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_161A507EA588ADB3 ON pci_dev (chip_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pci_dev DROP CONSTRAINT FK_161A507EA588ADB3');
        $this->addSql('DROP INDEX IDX_161A507EA588ADB3');
        $this->addSql('ALTER TABLE pci_dev ADD expansion_chip_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pci_dev RENAME COLUMN chip_id TO chipset_part_id');
        $this->addSql('ALTER TABLE pci_dev ADD CONSTRAINT fk_161a507e36f0f0c7 FOREIGN KEY (chipset_part_id) REFERENCES chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pci_dev ADD CONSTRAINT fk_161a507e79a869a1 FOREIGN KEY (expansion_chip_id) REFERENCES expansion_chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_161a507e79a869a1 ON pci_dev (expansion_chip_id)');
        $this->addSql('CREATE INDEX idx_161a507e36f0f0c7 ON pci_dev (chipset_part_id)');
    }
}

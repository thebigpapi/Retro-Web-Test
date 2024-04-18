<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120221602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE pci_dev_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE pci_device_id_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pci_device_id (id INT NOT NULL, chip_id INT DEFAULT NULL, dev INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FB6722FCA588ADB3 ON pci_device_id (chip_id)');
        $this->addSql('ALTER TABLE pci_device_id ADD CONSTRAINT FK_FB6722FCA588ADB3 FOREIGN KEY (chip_id) REFERENCES chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pci_dev DROP CONSTRAINT fk_161a507ea588adb3');
        $this->addSql('DROP TABLE pci_dev');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE pci_device_id_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE pci_dev_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pci_dev (id INT NOT NULL, chip_id INT DEFAULT NULL, dev INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_161a507ea588adb3 ON pci_dev (chip_id)');
        $this->addSql('ALTER TABLE pci_dev ADD CONSTRAINT fk_161a507ea588adb3 FOREIGN KEY (chip_id) REFERENCES chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pci_device_id DROP CONSTRAINT FK_FB6722FCA588ADB3');
        $this->addSql('DROP TABLE pci_device_id');
    }
}

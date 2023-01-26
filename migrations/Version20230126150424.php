<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126150424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE pci_vendor_id_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pci_vendor_id (id INT NOT NULL, manufacturer_id INT DEFAULT NULL, ven INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_99C00B5BA23B42D ON pci_vendor_id (manufacturer_id)');
        $this->addSql('ALTER TABLE pci_vendor_id ADD CONSTRAINT FK_99C00B5BA23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manufacturer DROP pciven');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE pci_vendor_id_id_seq CASCADE');
        $this->addSql('ALTER TABLE pci_vendor_id DROP CONSTRAINT FK_99C00B5BA23B42D');
        $this->addSql('DROP TABLE pci_vendor_id');
        $this->addSql('ALTER TABLE manufacturer ADD pciven INT DEFAULT NULL');
    }
}

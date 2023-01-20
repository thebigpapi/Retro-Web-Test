<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120205708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE pci_dev_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pci_dev (id INT NOT NULL, chipset_part_id INT DEFAULT NULL, expansion_chip_id INT DEFAULT NULL, dev INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_161A507E36F0F0C7 ON pci_dev (chipset_part_id)');
        $this->addSql('CREATE INDEX IDX_161A507E79A869A1 ON pci_dev (expansion_chip_id)');
        $this->addSql('ALTER TABLE pci_dev ADD CONSTRAINT FK_161A507E36F0F0C7 FOREIGN KEY (chipset_part_id) REFERENCES chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pci_dev ADD CONSTRAINT FK_161A507E79A869A1 FOREIGN KEY (expansion_chip_id) REFERENCES expansion_chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE pci_dev_id_seq CASCADE');
        $this->addSql('ALTER TABLE pci_dev DROP CONSTRAINT FK_161A507E36F0F0C7');
        $this->addSql('ALTER TABLE pci_dev DROP CONSTRAINT FK_161A507E79A869A1');
        $this->addSql('DROP TABLE pci_dev');
    }
}

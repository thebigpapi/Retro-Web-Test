<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119212952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pci_device_id ADD expansion_card_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pci_device_id ADD CONSTRAINT FK_FB6722FC96EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FB6722FC96EC5E32 ON pci_device_id (expansion_card_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pci_device_id DROP CONSTRAINT FK_FB6722FC96EC5E32');
        $this->addSql('DROP INDEX IDX_FB6722FC96EC5E32');
        $this->addSql('ALTER TABLE pci_device_id DROP expansion_card_id');
    }
}

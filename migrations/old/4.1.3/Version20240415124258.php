<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415124258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entity_image DROP CONSTRAINT fk_69c931a68db8e228');
        $this->addSql('ALTER TABLE entity_image DROP CONSTRAINT fk_69c931a66e6229f4');
        $this->addSql('DROP INDEX idx_69c931a66e6229f4');
        $this->addSql('DROP INDEX idx_69c931a68db8e228');
        $this->addSql('ALTER TABLE entity_image ADD io_port_interface_signal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_image ADD expansion_slot_interface_signal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_image DROP io_port_signal_id');
        $this->addSql('ALTER TABLE entity_image DROP expansion_slot_signal_id');
        $this->addSql('ALTER TABLE entity_image ADD CONSTRAINT FK_69C931A6F9AD71B2 FOREIGN KEY (io_port_interface_signal_id) REFERENCES io_port_interface_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_image ADD CONSTRAINT FK_69C931A6238755BE FOREIGN KEY (expansion_slot_interface_signal_id) REFERENCES expansion_slot_interface_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_69C931A6F9AD71B2 ON entity_image (io_port_interface_signal_id)');
        $this->addSql('CREATE INDEX IDX_69C931A6238755BE ON entity_image (expansion_slot_interface_signal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE entity_image DROP CONSTRAINT FK_69C931A6F9AD71B2');
        $this->addSql('ALTER TABLE entity_image DROP CONSTRAINT FK_69C931A6238755BE');
        $this->addSql('DROP INDEX IDX_69C931A6F9AD71B2');
        $this->addSql('DROP INDEX IDX_69C931A6238755BE');
        $this->addSql('ALTER TABLE entity_image ADD io_port_signal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_image ADD expansion_slot_signal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_image DROP io_port_interface_signal_id');
        $this->addSql('ALTER TABLE entity_image DROP expansion_slot_interface_signal_id');
        $this->addSql('ALTER TABLE entity_image ADD CONSTRAINT fk_69c931a68db8e228 FOREIGN KEY (io_port_signal_id) REFERENCES io_port_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_image ADD CONSTRAINT fk_69c931a66e6229f4 FOREIGN KEY (expansion_slot_signal_id) REFERENCES expansion_slot_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_69c931a66e6229f4 ON entity_image (expansion_slot_signal_id)');
        $this->addSql('CREATE INDEX idx_69c931a68db8e228 ON entity_image (io_port_signal_id)');
    }
}

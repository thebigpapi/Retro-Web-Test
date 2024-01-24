<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112202320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_card DROP CONSTRAINT fk_8795c2d6dd859f77');
        $this->addSql('DROP SEQUENCE expansion_slot_type_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE expansion_slot_signal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_slot_signal (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE expansion_slot_type');
        $this->addSql('ALTER TABLE expansion_card DROP CONSTRAINT fk_8795c2d685c5d58e');
        $this->addSql('DROP INDEX idx_8795c2d6dd859f77');
        $this->addSql('DROP INDEX idx_8795c2d685c5d58e');
        $this->addSql('ALTER TABLE expansion_card ADD expansion_slot_interface_id INT NOT NULL');
        $this->addSql('ALTER TABLE expansion_card ADD expansion_slot_signal_id INT NOT NULL');
        $this->addSql('ALTER TABLE expansion_card DROP expansion_slot_id');
        $this->addSql('ALTER TABLE expansion_card DROP expansion_slot_type_id');
        $this->addSql('ALTER TABLE expansion_card ADD CONSTRAINT FK_8795C2D62896457A FOREIGN KEY (expansion_slot_interface_id) REFERENCES expansion_slot_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card ADD CONSTRAINT FK_8795C2D66E6229F4 FOREIGN KEY (expansion_slot_signal_id) REFERENCES expansion_slot_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8795C2D62896457A ON expansion_card (expansion_slot_interface_id)');
        $this->addSql('CREATE INDEX IDX_8795C2D66E6229F4 ON expansion_card (expansion_slot_signal_id)');
        $this->addSql('ALTER TABLE expansion_card_io_port DROP CONSTRAINT fk_3a34a3b2a211d31');
        $this->addSql('DROP INDEX idx_3a34a3b2a211d31');
        $this->addSql('ALTER TABLE expansion_card_io_port RENAME COLUMN io_port_id TO io_port_interface_id');
        $this->addSql('ALTER TABLE expansion_card_io_port ADD CONSTRAINT FK_3A34A3BE20DBC82 FOREIGN KEY (io_port_interface_id) REFERENCES io_port_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3A34A3BE20DBC82 ON expansion_card_io_port (io_port_interface_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_card DROP CONSTRAINT FK_8795C2D66E6229F4');
        $this->addSql('DROP SEQUENCE expansion_slot_signal_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE expansion_slot_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_slot_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE expansion_slot_signal');
        $this->addSql('ALTER TABLE expansion_card DROP CONSTRAINT FK_8795C2D62896457A');
        $this->addSql('DROP INDEX IDX_8795C2D62896457A');
        $this->addSql('DROP INDEX IDX_8795C2D66E6229F4');
        $this->addSql('ALTER TABLE expansion_card ADD expansion_slot_id INT NOT NULL');
        $this->addSql('ALTER TABLE expansion_card ADD expansion_slot_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE expansion_card DROP expansion_slot_interface_id');
        $this->addSql('ALTER TABLE expansion_card DROP expansion_slot_signal_id');
        $this->addSql('ALTER TABLE expansion_card ADD CONSTRAINT fk_8795c2d6dd859f77 FOREIGN KEY (expansion_slot_type_id) REFERENCES expansion_slot_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card ADD CONSTRAINT fk_8795c2d685c5d58e FOREIGN KEY (expansion_slot_id) REFERENCES expansion_slot_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8795c2d6dd859f77 ON expansion_card (expansion_slot_type_id)');
        $this->addSql('CREATE INDEX idx_8795c2d685c5d58e ON expansion_card (expansion_slot_id)');
        $this->addSql('ALTER TABLE expansion_card_io_port DROP CONSTRAINT FK_3A34A3BE20DBC82');
        $this->addSql('DROP INDEX IDX_3A34A3BE20DBC82');
        $this->addSql('ALTER TABLE expansion_card_io_port RENAME COLUMN io_port_interface_id TO io_port_id');
        $this->addSql('ALTER TABLE expansion_card_io_port ADD CONSTRAINT fk_3a34a3b2a211d31 FOREIGN KEY (io_port_id) REFERENCES io_port_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3a34a3b2a211d31 ON expansion_card_io_port (io_port_id)');
    }
}

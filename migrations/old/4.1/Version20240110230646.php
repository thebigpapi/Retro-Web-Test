<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240110230646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE expansion_card_io_port_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE expansion_slot2_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE expansion_slot_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE io_port2_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE io_port_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_card_io_port (id INT NOT NULL, expansion_card_id INT NOT NULL, io_port_id INT NOT NULL, count INT NOT NULL, is_internal BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3A34A3B96EC5E32 ON expansion_card_io_port (expansion_card_id)');
        $this->addSql('CREATE INDEX IDX_3A34A3B2A211D31 ON expansion_card_io_port (io_port_id)');
        $this->addSql('CREATE TABLE expansion_card_io_port_io_port_type (expansion_card_io_port_id INT NOT NULL, io_port_type_id INT NOT NULL, PRIMARY KEY(expansion_card_io_port_id, io_port_type_id))');
        $this->addSql('CREATE INDEX IDX_A3FF080BB369A9F ON expansion_card_io_port_io_port_type (expansion_card_io_port_id)');
        $this->addSql('CREATE INDEX IDX_A3FF080B7B9F1E01 ON expansion_card_io_port_io_port_type (io_port_type_id)');
        $this->addSql('CREATE TABLE expansion_slot2 (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE expansion_slot_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE io_port2 (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE io_port_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE expansion_card_io_port ADD CONSTRAINT FK_3A34A3B96EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_io_port ADD CONSTRAINT FK_3A34A3B2A211D31 FOREIGN KEY (io_port_id) REFERENCES io_port2 (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_io_port_io_port_type ADD CONSTRAINT FK_A3FF080BB369A9F FOREIGN KEY (expansion_card_io_port_id) REFERENCES expansion_card_io_port (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_io_port_io_port_type ADD CONSTRAINT FK_A3FF080B7B9F1E01 FOREIGN KEY (io_port_type_id) REFERENCES io_port_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card ADD expansion_slot_id INT NOT NULL');
        $this->addSql('ALTER TABLE expansion_card ADD expansion_slot_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE expansion_card ADD CONSTRAINT FK_8795C2D685C5D58E FOREIGN KEY (expansion_slot_id) REFERENCES expansion_slot2 (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card ADD CONSTRAINT FK_8795C2D6DD859F77 FOREIGN KEY (expansion_slot_type_id) REFERENCES expansion_slot_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8795C2D685C5D58E ON expansion_card (expansion_slot_id)');
        $this->addSql('CREATE INDEX IDX_8795C2D6DD859F77 ON expansion_card (expansion_slot_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expansion_card DROP CONSTRAINT FK_8795C2D685C5D58E');
        $this->addSql('ALTER TABLE expansion_card DROP CONSTRAINT FK_8795C2D6DD859F77');
        $this->addSql('DROP SEQUENCE expansion_card_io_port_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE expansion_slot2_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE expansion_slot_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE io_port2_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE io_port_type_id_seq CASCADE');
        $this->addSql('ALTER TABLE expansion_card_io_port DROP CONSTRAINT FK_3A34A3B96EC5E32');
        $this->addSql('ALTER TABLE expansion_card_io_port DROP CONSTRAINT FK_3A34A3B2A211D31');
        $this->addSql('ALTER TABLE expansion_card_io_port_io_port_type DROP CONSTRAINT FK_A3FF080BB369A9F');
        $this->addSql('ALTER TABLE expansion_card_io_port_io_port_type DROP CONSTRAINT FK_A3FF080B7B9F1E01');
        $this->addSql('DROP TABLE expansion_card_io_port');
        $this->addSql('DROP TABLE expansion_card_io_port_io_port_type');
        $this->addSql('DROP TABLE expansion_slot2');
        $this->addSql('DROP TABLE expansion_slot_type');
        $this->addSql('DROP TABLE io_port2');
        $this->addSql('DROP TABLE io_port_type');
        $this->addSql('DROP INDEX IDX_8795C2D685C5D58E');
        $this->addSql('DROP INDEX IDX_8795C2D6DD859F77');
        $this->addSql('ALTER TABLE expansion_card DROP expansion_slot_id');
        $this->addSql('ALTER TABLE expansion_card DROP expansion_slot_type_id');
    }
}

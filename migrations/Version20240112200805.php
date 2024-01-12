<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112200805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_card DROP CONSTRAINT fk_8795c2d685c5d58e');
        $this->addSql('DROP SEQUENCE expansion_slot2_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE expansion_slot_interface_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_slot_interface (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE expansion_slot2');
        $this->addSql('ALTER TABLE expansion_card ADD CONSTRAINT FK_8795C2D685C5D58E FOREIGN KEY (expansion_slot_id) REFERENCES expansion_slot_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_card DROP CONSTRAINT FK_8795C2D685C5D58E');
        $this->addSql('DROP SEQUENCE expansion_slot_interface_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE expansion_slot2_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_slot2 (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE expansion_slot_interface');
        $this->addSql('ALTER TABLE expansion_card ADD CONSTRAINT fk_8795c2d685c5d58e FOREIGN KEY (expansion_slot_id) REFERENCES expansion_slot2 (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}

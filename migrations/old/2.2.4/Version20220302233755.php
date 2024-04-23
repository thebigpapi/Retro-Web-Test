<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220302233755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_slot DROP CONSTRAINT fk_3d8f7a624d085745');
        $this->addSql('DROP SEQUENCE expansion_connector_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE trace_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE trace (id INT NOT NULL, username VARCHAR(255) NOT NULL, event_type VARCHAR(255) NOT NULL, object_type VARCHAR(255) NOT NULL, object_id INT NOT NULL, content VARCHAR(10000) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE expansion_connector');
        $this->addSql('DROP TABLE import');
        $this->addSql('DROP INDEX idx_3d8f7a624d085745');
        $this->addSql('ALTER TABLE expansion_slot DROP connector_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE trace_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE expansion_connector_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_connector (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE import (id INT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL)');
        $this->addSql('DROP TABLE trace');
        $this->addSql('ALTER TABLE expansion_slot ADD connector_id INT NOT NULL');
        $this->addSql('ALTER TABLE expansion_slot ADD CONSTRAINT fk_3d8f7a624d085745 FOREIGN KEY (connector_id) REFERENCES expansion_connector (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3d8f7a624d085745 ON expansion_slot (connector_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240404233254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE os_architecture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE large_file_os_architecture (large_file_id INT NOT NULL, os_architecture_id INT NOT NULL, PRIMARY KEY(large_file_id, os_architecture_id))');
        $this->addSql('CREATE INDEX IDX_457E9E7B29EA72E8 ON large_file_os_architecture (large_file_id)');
        $this->addSql('CREATE INDEX IDX_457E9E7BA318F243 ON large_file_os_architecture (os_architecture_id)');
        $this->addSql('CREATE TABLE os_architecture (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO os_architecture (id, name) VALUES (1, \'x86\')');
        $this->addSql('INSERT INTO os_architecture (id, name) VALUES (2, \'x64\')');
        $this->addSql('INSERT INTO os_architecture (id, name) VALUES (3, \'IA64\')');
        $this->addSql('INSERT INTO os_architecture (id, name) VALUES (4, \'MIPS\')');
        $this->addSql('INSERT INTO os_architecture (id, name) VALUES (5, \'PPC\')');
        $this->addSql('INSERT INTO os_architecture (id, name) VALUES (6, \'ALPHA\')');
        $this->addSql('CREATE TABLE os_architecture_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_70c152630d3df4906d7e70d03592ab15_idx ON os_architecture_audit (type)');
        $this->addSql('CREATE INDEX object_id_70c152630d3df4906d7e70d03592ab15_idx ON os_architecture_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_70c152630d3df4906d7e70d03592ab15_idx ON os_architecture_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_70c152630d3df4906d7e70d03592ab15_idx ON os_architecture_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_70c152630d3df4906d7e70d03592ab15_idx ON os_architecture_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_70c152630d3df4906d7e70d03592ab15_idx ON os_architecture_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN os_architecture_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE large_file_os_architecture ADD CONSTRAINT FK_457E9E7B29EA72E8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_os_architecture ADD CONSTRAINT FK_457E9E7BA318F243 FOREIGN KEY (os_architecture_id) REFERENCES os_architecture (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE os_architecture_id_seq CASCADE');
        $this->addSql('ALTER TABLE large_file_os_architecture DROP CONSTRAINT FK_457E9E7B29EA72E8');
        $this->addSql('ALTER TABLE large_file_os_architecture DROP CONSTRAINT FK_457E9E7BA318F243');
        $this->addSql('DROP TABLE large_file_os_architecture');
        $this->addSql('DROP TABLE os_architecture');
        $this->addSql('DROP TABLE os_architecture_audit');
    }
}

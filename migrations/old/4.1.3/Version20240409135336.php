<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409135336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE expansion_chip_bios_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_chip_bios (id INT NOT NULL, expansion_chip_id INT DEFAULT NULL, version VARCHAR(255) DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, note VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, hash VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_361B7CBF79A869A1 ON expansion_chip_bios (expansion_chip_id)');
        $this->addSql('CREATE TABLE expansion_chip_bios_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_801d06dc80912a4da419387ca0e75770_idx ON expansion_chip_bios_audit (type)');
        $this->addSql('CREATE INDEX object_id_801d06dc80912a4da419387ca0e75770_idx ON expansion_chip_bios_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_801d06dc80912a4da419387ca0e75770_idx ON expansion_chip_bios_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_801d06dc80912a4da419387ca0e75770_idx ON expansion_chip_bios_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_801d06dc80912a4da419387ca0e75770_idx ON expansion_chip_bios_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_801d06dc80912a4da419387ca0e75770_idx ON expansion_chip_bios_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_chip_bios_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE expansion_chip_bios ADD CONSTRAINT FK_361B7CBF79A869A1 FOREIGN KEY (expansion_chip_id) REFERENCES expansion_chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE expansion_chip_bios_id_seq CASCADE');
        $this->addSql('ALTER TABLE expansion_chip_bios DROP CONSTRAINT FK_361B7CBF79A869A1');
        $this->addSql('DROP TABLE expansion_chip_bios');
        $this->addSql('DROP TABLE expansion_chip_bios_audit');
    }
}

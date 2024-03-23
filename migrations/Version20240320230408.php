<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320230408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE storage_device_misc_file_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE storage_device_misc_file (id INT NOT NULL, storage_device_id INT DEFAULT NULL, file_name VARCHAR(255) NOT NULL, link_name VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FB2AD4EB7CBFD8DB ON storage_device_misc_file (storage_device_id)');
        $this->addSql('CREATE TABLE storage_device_misc_file_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_08c546d4bbe78349a0d5a115021c9ded_idx ON storage_device_misc_file_audit (type)');
        $this->addSql('CREATE INDEX object_id_08c546d4bbe78349a0d5a115021c9ded_idx ON storage_device_misc_file_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_08c546d4bbe78349a0d5a115021c9ded_idx ON storage_device_misc_file_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_08c546d4bbe78349a0d5a115021c9ded_idx ON storage_device_misc_file_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_08c546d4bbe78349a0d5a115021c9ded_idx ON storage_device_misc_file_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_08c546d4bbe78349a0d5a115021c9ded_idx ON storage_device_misc_file_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN storage_device_misc_file_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE storage_device_misc_file ADD CONSTRAINT FK_FB2AD4EB7CBFD8DB FOREIGN KEY (storage_device_id) REFERENCES storage_device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE storage_device_misc_file_id_seq CASCADE');
        $this->addSql('ALTER TABLE storage_device_misc_file DROP CONSTRAINT FK_FB2AD4EB7CBFD8DB');
        $this->addSql('DROP TABLE storage_device_misc_file');
        $this->addSql('DROP TABLE storage_device_misc_file_audit');
    }
}

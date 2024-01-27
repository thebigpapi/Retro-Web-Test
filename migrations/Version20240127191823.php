<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240127191823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE large_file_media_type_flag_audit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE large_file_media_type_flag_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media_type_flag_audit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media_type_flag_id_seq CASCADE');
        $this->addSql('ALTER TABLE large_file_media_type_flag DROP CONSTRAINT fk_10386ab129ea72e8');
        $this->addSql('ALTER TABLE large_file_media_type_flag DROP CONSTRAINT fk_10386ab1d04f219c');
        $this->addSql('DROP TABLE large_file_media_type_flag');
        $this->addSql('DROP TABLE large_file_media_type_flag_audit');
        $this->addSql('DROP TABLE media_type_flag_audit');
        $this->addSql('DROP TABLE media_type_flag');
        $this->addSql('DELETE FROM large_file_audit');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE large_file_media_type_flag_audit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE large_file_media_type_flag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media_type_flag_audit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media_type_flag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE large_file_media_type_flag (id INT NOT NULL, large_file_id INT NOT NULL, media_type_flag_id INT NOT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_10386ab1d04f219c ON large_file_media_type_flag (media_type_flag_id)');
        $this->addSql('CREATE INDEX idx_10386ab129ea72e8 ON large_file_media_type_flag (large_file_id)');
        $this->addSql('CREATE TABLE large_file_media_type_flag_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_3513e78b4c2d3d39e7e153d9cef36f6f_idx ON large_file_media_type_flag_audit (type)');
        $this->addSql('CREATE INDEX transaction_hash_3513e78b4c2d3d39e7e153d9cef36f6f_idx ON large_file_media_type_flag_audit (transaction_hash)');
        $this->addSql('CREATE INDEX object_id_3513e78b4c2d3d39e7e153d9cef36f6f_idx ON large_file_media_type_flag_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_3513e78b4c2d3d39e7e153d9cef36f6f_idx ON large_file_media_type_flag_audit (discriminator)');
        $this->addSql('CREATE INDEX created_at_3513e78b4c2d3d39e7e153d9cef36f6f_idx ON large_file_media_type_flag_audit (created_at)');
        $this->addSql('CREATE INDEX blame_id_3513e78b4c2d3d39e7e153d9cef36f6f_idx ON large_file_media_type_flag_audit (blame_id)');
        $this->addSql('COMMENT ON COLUMN large_file_media_type_flag_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE media_type_flag_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_507644644feed4277a39e25d4336dbd5_idx ON media_type_flag_audit (type)');
        $this->addSql('CREATE INDEX transaction_hash_507644644feed4277a39e25d4336dbd5_idx ON media_type_flag_audit (transaction_hash)');
        $this->addSql('CREATE INDEX object_id_507644644feed4277a39e25d4336dbd5_idx ON media_type_flag_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_507644644feed4277a39e25d4336dbd5_idx ON media_type_flag_audit (discriminator)');
        $this->addSql('CREATE INDEX created_at_507644644feed4277a39e25d4336dbd5_idx ON media_type_flag_audit (created_at)');
        $this->addSql('CREATE INDEX blame_id_507644644feed4277a39e25d4336dbd5_idx ON media_type_flag_audit (blame_id)');
        $this->addSql('COMMENT ON COLUMN media_type_flag_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE media_type_flag (id INT NOT NULL, name VARCHAR(255) NOT NULL, tag_name VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE large_file_media_type_flag ADD CONSTRAINT fk_10386ab129ea72e8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_media_type_flag ADD CONSTRAINT fk_10386ab1d04f219c FOREIGN KEY (media_type_flag_id) REFERENCES media_type_flag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}

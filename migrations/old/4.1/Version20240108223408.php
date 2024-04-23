<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108223408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE cache_method_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cache_ratio_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE expansion_card_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE expansion_card_alias_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE expansion_card_bios_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE expansion_card_documentation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE expansion_card_image_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE expansion_card_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE large_file_expansion_card_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_card (id INT NOT NULL, manufacturer_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(4096) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8795C2D6A23B42D ON expansion_card (manufacturer_id)');
        $this->addSql('CREATE TABLE expansion_card_expansion_chip (expansion_card_id INT NOT NULL, expansion_chip_id INT NOT NULL, PRIMARY KEY(expansion_card_id, expansion_chip_id))');
        $this->addSql('CREATE INDEX IDX_3B8C114596EC5E32 ON expansion_card_expansion_chip (expansion_card_id)');
        $this->addSql('CREATE INDEX IDX_3B8C114579A869A1 ON expansion_card_expansion_chip (expansion_chip_id)');
        $this->addSql('CREATE TABLE expansion_card_psuconnector (expansion_card_id INT NOT NULL, psuconnector_id INT NOT NULL, PRIMARY KEY(expansion_card_id, psuconnector_id))');
        $this->addSql('CREATE INDEX IDX_99E2CA8696EC5E32 ON expansion_card_psuconnector (expansion_card_id)');
        $this->addSql('CREATE INDEX IDX_99E2CA86D6871168 ON expansion_card_psuconnector (psuconnector_id)');
        $this->addSql('CREATE TABLE expansion_card_expansion_card_type (expansion_card_id INT NOT NULL, expansion_card_type_id INT NOT NULL, PRIMARY KEY(expansion_card_id, expansion_card_type_id))');
        $this->addSql('CREATE INDEX IDX_9F015EBF96EC5E32 ON expansion_card_expansion_card_type (expansion_card_id)');
        $this->addSql('CREATE INDEX IDX_9F015EBF649977A5 ON expansion_card_expansion_card_type (expansion_card_type_id)');
        $this->addSql('CREATE TABLE expansion_card_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_3eec7dfc4799ce16d8de68bc1ab53678_idx ON expansion_card_audit (type)');
        $this->addSql('CREATE INDEX object_id_3eec7dfc4799ce16d8de68bc1ab53678_idx ON expansion_card_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_3eec7dfc4799ce16d8de68bc1ab53678_idx ON expansion_card_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_3eec7dfc4799ce16d8de68bc1ab53678_idx ON expansion_card_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_3eec7dfc4799ce16d8de68bc1ab53678_idx ON expansion_card_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_3eec7dfc4799ce16d8de68bc1ab53678_idx ON expansion_card_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_card_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE expansion_card_alias (id INT NOT NULL, manufacturer_id INT DEFAULT NULL, expansion_card_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5202DF12A23B42D ON expansion_card_alias (manufacturer_id)');
        $this->addSql('CREATE INDEX IDX_5202DF1296EC5E32 ON expansion_card_alias (expansion_card_id)');
        $this->addSql('CREATE TABLE expansion_card_alias_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_6ac61bdce41c9bb8a348d5bd6f5104b9_idx ON expansion_card_alias_audit (type)');
        $this->addSql('CREATE INDEX object_id_6ac61bdce41c9bb8a348d5bd6f5104b9_idx ON expansion_card_alias_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_6ac61bdce41c9bb8a348d5bd6f5104b9_idx ON expansion_card_alias_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_6ac61bdce41c9bb8a348d5bd6f5104b9_idx ON expansion_card_alias_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_6ac61bdce41c9bb8a348d5bd6f5104b9_idx ON expansion_card_alias_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_6ac61bdce41c9bb8a348d5bd6f5104b9_idx ON expansion_card_alias_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_card_alias_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE expansion_card_bios (id INT NOT NULL, expansion_card_id INT DEFAULT NULL, version VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D4CAEF2D96EC5E32 ON expansion_card_bios (expansion_card_id)');
        $this->addSql('CREATE TABLE expansion_card_bios_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_49b4bf2071a6d437b46a0ceee82d9ec2_idx ON expansion_card_bios_audit (type)');
        $this->addSql('CREATE INDEX object_id_49b4bf2071a6d437b46a0ceee82d9ec2_idx ON expansion_card_bios_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_49b4bf2071a6d437b46a0ceee82d9ec2_idx ON expansion_card_bios_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_49b4bf2071a6d437b46a0ceee82d9ec2_idx ON expansion_card_bios_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_49b4bf2071a6d437b46a0ceee82d9ec2_idx ON expansion_card_bios_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_49b4bf2071a6d437b46a0ceee82d9ec2_idx ON expansion_card_bios_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_card_bios_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE expansion_card_documentation (id INT NOT NULL, expansion_card_id INT DEFAULT NULL, language_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, link_name VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, release_date DATE DEFAULT NULL, date_precision VARCHAR(1) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5722523B96EC5E32 ON expansion_card_documentation (expansion_card_id)');
        $this->addSql('CREATE INDEX IDX_5722523B82F1BAF4 ON expansion_card_documentation (language_id)');
        $this->addSql('CREATE TABLE expansion_card_documentation_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_6806ed27bf931cf560a0f4be1725f8bd_idx ON expansion_card_documentation_audit (type)');
        $this->addSql('CREATE INDEX object_id_6806ed27bf931cf560a0f4be1725f8bd_idx ON expansion_card_documentation_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_6806ed27bf931cf560a0f4be1725f8bd_idx ON expansion_card_documentation_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_6806ed27bf931cf560a0f4be1725f8bd_idx ON expansion_card_documentation_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_6806ed27bf931cf560a0f4be1725f8bd_idx ON expansion_card_documentation_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_6806ed27bf931cf560a0f4be1725f8bd_idx ON expansion_card_documentation_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_card_documentation_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE expansion_card_image (id INT NOT NULL, creditor_id INT DEFAULT NULL, expansion_card_id INT DEFAULT NULL, file_name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7653B0D9DF91AC92 ON expansion_card_image (creditor_id)');
        $this->addSql('CREATE INDEX IDX_7653B0D996EC5E32 ON expansion_card_image (expansion_card_id)');
        $this->addSql('CREATE TABLE expansion_card_image_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_2a505021b6893879783e09cdd6092d6e_idx ON expansion_card_image_audit (type)');
        $this->addSql('CREATE INDEX object_id_2a505021b6893879783e09cdd6092d6e_idx ON expansion_card_image_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_2a505021b6893879783e09cdd6092d6e_idx ON expansion_card_image_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_2a505021b6893879783e09cdd6092d6e_idx ON expansion_card_image_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_2a505021b6893879783e09cdd6092d6e_idx ON expansion_card_image_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_2a505021b6893879783e09cdd6092d6e_idx ON expansion_card_image_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_card_image_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE expansion_card_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE expansion_card_type_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_aa71eab6ce8ece9258c5ec80ad1a81df_idx ON expansion_card_type_audit (type)');
        $this->addSql('CREATE INDEX object_id_aa71eab6ce8ece9258c5ec80ad1a81df_idx ON expansion_card_type_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_aa71eab6ce8ece9258c5ec80ad1a81df_idx ON expansion_card_type_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_aa71eab6ce8ece9258c5ec80ad1a81df_idx ON expansion_card_type_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_aa71eab6ce8ece9258c5ec80ad1a81df_idx ON expansion_card_type_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_aa71eab6ce8ece9258c5ec80ad1a81df_idx ON expansion_card_type_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_card_type_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE large_file_expansion_card (id INT NOT NULL, large_file_id INT NOT NULL, expansion_card_id INT NOT NULL, is_recommended BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_277F8ABB29EA72E8 ON large_file_expansion_card (large_file_id)');
        $this->addSql('CREATE INDEX IDX_277F8ABB96EC5E32 ON large_file_expansion_card (expansion_card_id)');
        $this->addSql('CREATE TABLE large_file_expansion_card_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_f6ae91f44b5ebd7d74b5ca54e51aaea2_idx ON large_file_expansion_card_audit (type)');
        $this->addSql('CREATE INDEX object_id_f6ae91f44b5ebd7d74b5ca54e51aaea2_idx ON large_file_expansion_card_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_f6ae91f44b5ebd7d74b5ca54e51aaea2_idx ON large_file_expansion_card_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_f6ae91f44b5ebd7d74b5ca54e51aaea2_idx ON large_file_expansion_card_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_f6ae91f44b5ebd7d74b5ca54e51aaea2_idx ON large_file_expansion_card_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_f6ae91f44b5ebd7d74b5ca54e51aaea2_idx ON large_file_expansion_card_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN large_file_expansion_card_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE expansion_card ADD CONSTRAINT FK_8795C2D6A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_expansion_chip ADD CONSTRAINT FK_3B8C114596EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_expansion_chip ADD CONSTRAINT FK_3B8C114579A869A1 FOREIGN KEY (expansion_chip_id) REFERENCES expansion_chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_psuconnector ADD CONSTRAINT FK_99E2CA8696EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_psuconnector ADD CONSTRAINT FK_99E2CA86D6871168 FOREIGN KEY (psuconnector_id) REFERENCES psuconnector (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_expansion_card_type ADD CONSTRAINT FK_9F015EBF96EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_expansion_card_type ADD CONSTRAINT FK_9F015EBF649977A5 FOREIGN KEY (expansion_card_type_id) REFERENCES expansion_card_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_alias ADD CONSTRAINT FK_5202DF12A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_alias ADD CONSTRAINT FK_5202DF1296EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_bios ADD CONSTRAINT FK_D4CAEF2D96EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_documentation ADD CONSTRAINT FK_5722523B96EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_documentation ADD CONSTRAINT FK_5722523B82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_image ADD CONSTRAINT FK_7653B0D9DF91AC92 FOREIGN KEY (creditor_id) REFERENCES creditor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_image ADD CONSTRAINT FK_7653B0D996EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_expansion_card ADD CONSTRAINT FK_277F8ABB29EA72E8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_expansion_card ADD CONSTRAINT FK_277F8ABB96EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE cache_method');
        $this->addSql('DROP TABLE cache_ratio');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE expansion_card_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE expansion_card_alias_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE expansion_card_bios_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE expansion_card_documentation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE expansion_card_image_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE expansion_card_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE large_file_expansion_card_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE cache_method_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cache_ratio_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cache_method (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cache_ratio (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE expansion_card DROP CONSTRAINT FK_8795C2D6A23B42D');
        $this->addSql('ALTER TABLE expansion_card_expansion_chip DROP CONSTRAINT FK_3B8C114596EC5E32');
        $this->addSql('ALTER TABLE expansion_card_expansion_chip DROP CONSTRAINT FK_3B8C114579A869A1');
        $this->addSql('ALTER TABLE expansion_card_psuconnector DROP CONSTRAINT FK_99E2CA8696EC5E32');
        $this->addSql('ALTER TABLE expansion_card_psuconnector DROP CONSTRAINT FK_99E2CA86D6871168');
        $this->addSql('ALTER TABLE expansion_card_expansion_card_type DROP CONSTRAINT FK_9F015EBF96EC5E32');
        $this->addSql('ALTER TABLE expansion_card_expansion_card_type DROP CONSTRAINT FK_9F015EBF649977A5');
        $this->addSql('ALTER TABLE expansion_card_alias DROP CONSTRAINT FK_5202DF12A23B42D');
        $this->addSql('ALTER TABLE expansion_card_alias DROP CONSTRAINT FK_5202DF1296EC5E32');
        $this->addSql('ALTER TABLE expansion_card_bios DROP CONSTRAINT FK_D4CAEF2D96EC5E32');
        $this->addSql('ALTER TABLE expansion_card_documentation DROP CONSTRAINT FK_5722523B96EC5E32');
        $this->addSql('ALTER TABLE expansion_card_documentation DROP CONSTRAINT FK_5722523B82F1BAF4');
        $this->addSql('ALTER TABLE expansion_card_image DROP CONSTRAINT FK_7653B0D9DF91AC92');
        $this->addSql('ALTER TABLE expansion_card_image DROP CONSTRAINT FK_7653B0D996EC5E32');
        $this->addSql('ALTER TABLE large_file_expansion_card DROP CONSTRAINT FK_277F8ABB29EA72E8');
        $this->addSql('ALTER TABLE large_file_expansion_card DROP CONSTRAINT FK_277F8ABB96EC5E32');
        $this->addSql('DROP TABLE expansion_card');
        $this->addSql('DROP TABLE expansion_card_expansion_chip');
        $this->addSql('DROP TABLE expansion_card_psuconnector');
        $this->addSql('DROP TABLE expansion_card_expansion_card_type');
        $this->addSql('DROP TABLE expansion_card_audit');
        $this->addSql('DROP TABLE expansion_card_alias');
        $this->addSql('DROP TABLE expansion_card_alias_audit');
        $this->addSql('DROP TABLE expansion_card_bios');
        $this->addSql('DROP TABLE expansion_card_bios_audit');
        $this->addSql('DROP TABLE expansion_card_documentation');
        $this->addSql('DROP TABLE expansion_card_documentation_audit');
        $this->addSql('DROP TABLE expansion_card_image');
        $this->addSql('DROP TABLE expansion_card_image_audit');
        $this->addSql('DROP TABLE expansion_card_type');
        $this->addSql('DROP TABLE expansion_card_type_audit');
        $this->addSql('DROP TABLE large_file_expansion_card');
        $this->addSql('DROP TABLE large_file_expansion_card_audit');
    }
}

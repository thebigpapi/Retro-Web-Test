<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024125946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE entity_documentation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE entity_image_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE entity_documentation (id INT NOT NULL, processor_platform_type_id INT DEFAULT NULL, psu_connector_id INT DEFAULT NULL, cpu_socket_id INT DEFAULT NULL, language_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, link_name VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_527E0537A90B5CBC ON entity_documentation (processor_platform_type_id)');
        $this->addSql('CREATE INDEX IDX_527E05375217E6DF ON entity_documentation (psu_connector_id)');
        $this->addSql('CREATE INDEX IDX_527E05376B6A65A0 ON entity_documentation (cpu_socket_id)');
        $this->addSql('CREATE INDEX IDX_527E053782F1BAF4 ON entity_documentation (language_id)');
        $this->addSql('CREATE TABLE entity_documentation_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_e3c53719b83655f25a2faad0e71725c8_idx ON entity_documentation_audit (type)');
        $this->addSql('CREATE INDEX object_id_e3c53719b83655f25a2faad0e71725c8_idx ON entity_documentation_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_e3c53719b83655f25a2faad0e71725c8_idx ON entity_documentation_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_e3c53719b83655f25a2faad0e71725c8_idx ON entity_documentation_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_e3c53719b83655f25a2faad0e71725c8_idx ON entity_documentation_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_e3c53719b83655f25a2faad0e71725c8_idx ON entity_documentation_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN entity_documentation_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE entity_image (id INT NOT NULL, creditor_id INT DEFAULT NULL, psu_connector_id INT DEFAULT NULL, cpu_socket_id INT DEFAULT NULL, file_name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_69C931A6DF91AC92 ON entity_image (creditor_id)');
        $this->addSql('CREATE INDEX IDX_69C931A65217E6DF ON entity_image (psu_connector_id)');
        $this->addSql('CREATE INDEX IDX_69C931A66B6A65A0 ON entity_image (cpu_socket_id)');
        $this->addSql('CREATE TABLE entity_image_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_3af4cbbe75153f95127071e932b852d4_idx ON entity_image_audit (type)');
        $this->addSql('CREATE INDEX object_id_3af4cbbe75153f95127071e932b852d4_idx ON entity_image_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_3af4cbbe75153f95127071e932b852d4_idx ON entity_image_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_3af4cbbe75153f95127071e932b852d4_idx ON entity_image_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_3af4cbbe75153f95127071e932b852d4_idx ON entity_image_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_3af4cbbe75153f95127071e932b852d4_idx ON entity_image_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN entity_image_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE entity_documentation ADD CONSTRAINT FK_527E0537A90B5CBC FOREIGN KEY (processor_platform_type_id) REFERENCES processor_platform_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_documentation ADD CONSTRAINT FK_527E05375217E6DF FOREIGN KEY (psu_connector_id) REFERENCES psuconnector (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_documentation ADD CONSTRAINT FK_527E05376B6A65A0 FOREIGN KEY (cpu_socket_id) REFERENCES cpu_socket (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_documentation ADD CONSTRAINT FK_527E053782F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_image ADD CONSTRAINT FK_69C931A6DF91AC92 FOREIGN KEY (creditor_id) REFERENCES creditor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_image ADD CONSTRAINT FK_69C931A65217E6DF FOREIGN KEY (psu_connector_id) REFERENCES psuconnector (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_image ADD CONSTRAINT FK_69C931A66B6A65A0 FOREIGN KEY (cpu_socket_id) REFERENCES cpu_socket (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cpu_socket ADD description VARCHAR(4096) DEFAULT NULL');
        $this->addSql('ALTER TABLE processor_platform_type ADD description VARCHAR(4096) DEFAULT NULL');
        $this->addSql('ALTER TABLE psuconnector ADD description VARCHAR(4096) DEFAULT NULL');
        $this->addSql('ALTER TABLE psuconnector DROP website');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE entity_documentation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE entity_image_id_seq CASCADE');
        $this->addSql('ALTER TABLE entity_documentation DROP CONSTRAINT FK_527E0537A90B5CBC');
        $this->addSql('ALTER TABLE entity_documentation DROP CONSTRAINT FK_527E05375217E6DF');
        $this->addSql('ALTER TABLE entity_documentation DROP CONSTRAINT FK_527E05376B6A65A0');
        $this->addSql('ALTER TABLE entity_documentation DROP CONSTRAINT FK_527E053782F1BAF4');
        $this->addSql('ALTER TABLE entity_image DROP CONSTRAINT FK_69C931A6DF91AC92');
        $this->addSql('ALTER TABLE entity_image DROP CONSTRAINT FK_69C931A65217E6DF');
        $this->addSql('ALTER TABLE entity_image DROP CONSTRAINT FK_69C931A66B6A65A0');
        $this->addSql('DROP TABLE entity_documentation');
        $this->addSql('DROP TABLE entity_documentation_audit');
        $this->addSql('DROP TABLE entity_image');
        $this->addSql('DROP TABLE entity_image_audit');
        $this->addSql('ALTER TABLE psuconnector DROP description');
        $this->addSql('ALTER TABLE cpu_socket DROP description');
        $this->addSql('ALTER TABLE processor_platform_type DROP description');
    }
}

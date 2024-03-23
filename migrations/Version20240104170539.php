<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240104170539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE manufacturer_code_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE manufacturer_code (id INT NOT NULL, manufacturer_id INT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F25E0157A23B42D ON manufacturer_code (manufacturer_id)');
        $this->addSql('CREATE TABLE manufacturer_code_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_98d0e0c970efb52b0f329a41d7cb2ac6_idx ON manufacturer_code_audit (type)');
        $this->addSql('CREATE INDEX object_id_98d0e0c970efb52b0f329a41d7cb2ac6_idx ON manufacturer_code_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_98d0e0c970efb52b0f329a41d7cb2ac6_idx ON manufacturer_code_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_98d0e0c970efb52b0f329a41d7cb2ac6_idx ON manufacturer_code_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_98d0e0c970efb52b0f329a41d7cb2ac6_idx ON manufacturer_code_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_98d0e0c970efb52b0f329a41d7cb2ac6_idx ON manufacturer_code_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN manufacturer_code_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE manufacturer_code ADD CONSTRAINT FK_F25E0157A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manufacturer ADD description VARCHAR(8192) DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_image ADD manufacturer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_image ADD CONSTRAINT FK_69C931A6A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_69C931A6A23B42D ON entity_image (manufacturer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE manufacturer_code_id_seq CASCADE');
        $this->addSql('ALTER TABLE manufacturer_code DROP CONSTRAINT FK_F25E0157A23B42D');
        $this->addSql('DROP TABLE manufacturer_code');
        $this->addSql('DROP TABLE manufacturer_code_audit');
        $this->addSql('ALTER TABLE manufacturer DROP description');
        $this->addSql('ALTER TABLE entity_image DROP CONSTRAINT FK_69C931A6A23B42D');
        $this->addSql('DROP INDEX IDX_69C931A6A23B42D');
        $this->addSql('ALTER TABLE entity_image DROP manufacturer_id');
    }
}

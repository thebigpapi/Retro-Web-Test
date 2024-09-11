<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240818152738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE expansion_chip_audit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE processor_audit_id_seq CASCADE');
        $this->addSql('CREATE TABLE chip_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_77aeecf325007a6b9f6c7d4e8ff0603a_idx ON chip_audit (type)');
        $this->addSql('CREATE INDEX object_id_77aeecf325007a6b9f6c7d4e8ff0603a_idx ON chip_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_77aeecf325007a6b9f6c7d4e8ff0603a_idx ON chip_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_77aeecf325007a6b9f6c7d4e8ff0603a_idx ON chip_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_77aeecf325007a6b9f6c7d4e8ff0603a_idx ON chip_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_77aeecf325007a6b9f6c7d4e8ff0603a_idx ON chip_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN chip_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP TABLE processor_audit');
        $this->addSql('DROP TABLE expansion_chip_audit');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE expansion_chip_audit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE processor_audit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE processor_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_b6d6286db8bd767f58132d82dc1cfe3b_idx ON processor_audit (type)');
        $this->addSql('CREATE INDEX transaction_hash_b6d6286db8bd767f58132d82dc1cfe3b_idx ON processor_audit (transaction_hash)');
        $this->addSql('CREATE INDEX object_id_b6d6286db8bd767f58132d82dc1cfe3b_idx ON processor_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_b6d6286db8bd767f58132d82dc1cfe3b_idx ON processor_audit (discriminator)');
        $this->addSql('CREATE INDEX created_at_b6d6286db8bd767f58132d82dc1cfe3b_idx ON processor_audit (created_at)');
        $this->addSql('CREATE INDEX blame_id_b6d6286db8bd767f58132d82dc1cfe3b_idx ON processor_audit (blame_id)');
        $this->addSql('COMMENT ON COLUMN processor_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE expansion_chip_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_960347c7fe84eb6e28aed809aa9c7776_idx ON expansion_chip_audit (type)');
        $this->addSql('CREATE INDEX transaction_hash_960347c7fe84eb6e28aed809aa9c7776_idx ON expansion_chip_audit (transaction_hash)');
        $this->addSql('CREATE INDEX object_id_960347c7fe84eb6e28aed809aa9c7776_idx ON expansion_chip_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_960347c7fe84eb6e28aed809aa9c7776_idx ON expansion_chip_audit (discriminator)');
        $this->addSql('CREATE INDEX created_at_960347c7fe84eb6e28aed809aa9c7776_idx ON expansion_chip_audit (created_at)');
        $this->addSql('CREATE INDEX blame_id_960347c7fe84eb6e28aed809aa9c7776_idx ON expansion_chip_audit (blame_id)');
        $this->addSql('COMMENT ON COLUMN expansion_chip_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP TABLE chip_audit');
    }
}

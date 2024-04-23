<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219005152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE memory_connector_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_7c80a8a99d401e989ca64dfec13c8b73_idx ON memory_connector_audit (type)');
        $this->addSql('CREATE INDEX object_id_7c80a8a99d401e989ca64dfec13c8b73_idx ON memory_connector_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_7c80a8a99d401e989ca64dfec13c8b73_idx ON memory_connector_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_7c80a8a99d401e989ca64dfec13c8b73_idx ON memory_connector_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_7c80a8a99d401e989ca64dfec13c8b73_idx ON memory_connector_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_7c80a8a99d401e989ca64dfec13c8b73_idx ON memory_connector_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN memory_connector_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE motherboard_memory_connector_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_b28f4234c884e2d633923eedf3e9e1fc_idx ON motherboard_memory_connector_audit (type)');
        $this->addSql('CREATE INDEX object_id_b28f4234c884e2d633923eedf3e9e1fc_idx ON motherboard_memory_connector_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_b28f4234c884e2d633923eedf3e9e1fc_idx ON motherboard_memory_connector_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_b28f4234c884e2d633923eedf3e9e1fc_idx ON motherboard_memory_connector_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_b28f4234c884e2d633923eedf3e9e1fc_idx ON motherboard_memory_connector_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_b28f4234c884e2d633923eedf3e9e1fc_idx ON motherboard_memory_connector_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN motherboard_memory_connector_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE memory_connector_audit');
        $this->addSql('DROP TABLE motherboard_memory_connector_audit');
    }
}

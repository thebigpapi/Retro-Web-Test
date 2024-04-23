<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112235617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expansion_card_io_port_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_8ea03fa5d6a3857a3e508dba7e0470f0_idx ON expansion_card_io_port_audit (type)');
        $this->addSql('CREATE INDEX object_id_8ea03fa5d6a3857a3e508dba7e0470f0_idx ON expansion_card_io_port_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_8ea03fa5d6a3857a3e508dba7e0470f0_idx ON expansion_card_io_port_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_8ea03fa5d6a3857a3e508dba7e0470f0_idx ON expansion_card_io_port_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_8ea03fa5d6a3857a3e508dba7e0470f0_idx ON expansion_card_io_port_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_8ea03fa5d6a3857a3e508dba7e0470f0_idx ON expansion_card_io_port_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_card_io_port_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE expansion_card_memory_connector_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_bcbc46b8f37c9208ec839e2e56ac2421_idx ON expansion_card_memory_connector_audit (type)');
        $this->addSql('CREATE INDEX object_id_bcbc46b8f37c9208ec839e2e56ac2421_idx ON expansion_card_memory_connector_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_bcbc46b8f37c9208ec839e2e56ac2421_idx ON expansion_card_memory_connector_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_bcbc46b8f37c9208ec839e2e56ac2421_idx ON expansion_card_memory_connector_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_bcbc46b8f37c9208ec839e2e56ac2421_idx ON expansion_card_memory_connector_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_bcbc46b8f37c9208ec839e2e56ac2421_idx ON expansion_card_memory_connector_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_card_memory_connector_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE expansion_slot_interface_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_13ac03b74c8d202cf167f2b175121594_idx ON expansion_slot_interface_audit (type)');
        $this->addSql('CREATE INDEX object_id_13ac03b74c8d202cf167f2b175121594_idx ON expansion_slot_interface_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_13ac03b74c8d202cf167f2b175121594_idx ON expansion_slot_interface_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_13ac03b74c8d202cf167f2b175121594_idx ON expansion_slot_interface_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_13ac03b74c8d202cf167f2b175121594_idx ON expansion_slot_interface_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_13ac03b74c8d202cf167f2b175121594_idx ON expansion_slot_interface_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_slot_interface_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE expansion_slot_signal_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_14d4da6099c0c87dc4c7a879a43dadd1_idx ON expansion_slot_signal_audit (type)');
        $this->addSql('CREATE INDEX object_id_14d4da6099c0c87dc4c7a879a43dadd1_idx ON expansion_slot_signal_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_14d4da6099c0c87dc4c7a879a43dadd1_idx ON expansion_slot_signal_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_14d4da6099c0c87dc4c7a879a43dadd1_idx ON expansion_slot_signal_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_14d4da6099c0c87dc4c7a879a43dadd1_idx ON expansion_slot_signal_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_14d4da6099c0c87dc4c7a879a43dadd1_idx ON expansion_slot_signal_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_slot_signal_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE io_port_interface_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_d08d7cc3d78525fe87dc7673cc2204d9_idx ON io_port_interface_audit (type)');
        $this->addSql('CREATE INDEX object_id_d08d7cc3d78525fe87dc7673cc2204d9_idx ON io_port_interface_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_d08d7cc3d78525fe87dc7673cc2204d9_idx ON io_port_interface_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_d08d7cc3d78525fe87dc7673cc2204d9_idx ON io_port_interface_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_d08d7cc3d78525fe87dc7673cc2204d9_idx ON io_port_interface_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_d08d7cc3d78525fe87dc7673cc2204d9_idx ON io_port_interface_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN io_port_interface_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE io_port_signal_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_b1960baf17f6a5804b3f7dfd52f55fb4_idx ON io_port_signal_audit (type)');
        $this->addSql('CREATE INDEX object_id_b1960baf17f6a5804b3f7dfd52f55fb4_idx ON io_port_signal_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_b1960baf17f6a5804b3f7dfd52f55fb4_idx ON io_port_signal_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_b1960baf17f6a5804b3f7dfd52f55fb4_idx ON io_port_signal_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_b1960baf17f6a5804b3f7dfd52f55fb4_idx ON io_port_signal_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_b1960baf17f6a5804b3f7dfd52f55fb4_idx ON io_port_signal_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN io_port_signal_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE expansion_card_io_port_audit');
        $this->addSql('DROP TABLE expansion_card_memory_connector_audit');
        $this->addSql('DROP TABLE expansion_slot_interface_audit');
        $this->addSql('DROP TABLE expansion_slot_signal_audit');
        $this->addSql('DROP TABLE io_port_interface_audit');
        $this->addSql('DROP TABLE io_port_signal_audit');
    }
}

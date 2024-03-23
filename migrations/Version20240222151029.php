<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222151029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expansion_card_power_connector_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_a5490304f4b6e94c53e3df2473abc685_idx ON expansion_card_power_connector_audit (type)');
        $this->addSql('CREATE INDEX object_id_a5490304f4b6e94c53e3df2473abc685_idx ON expansion_card_power_connector_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_a5490304f4b6e94c53e3df2473abc685_idx ON expansion_card_power_connector_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_a5490304f4b6e94c53e3df2473abc685_idx ON expansion_card_power_connector_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_a5490304f4b6e94c53e3df2473abc685_idx ON expansion_card_power_connector_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_a5490304f4b6e94c53e3df2473abc685_idx ON expansion_card_power_connector_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_card_power_connector_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE expansion_card_psuconnector DROP CONSTRAINT fk_99e2ca8696ec5e32');
        $this->addSql('ALTER TABLE expansion_card_psuconnector DROP CONSTRAINT fk_99e2ca86d6871168');
        $this->addSql('DROP TABLE expansion_card_psuconnector');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE expansion_card_psuconnector (expansion_card_id INT NOT NULL, psuconnector_id INT NOT NULL, PRIMARY KEY(expansion_card_id, psuconnector_id))');
        $this->addSql('CREATE INDEX idx_99e2ca86d6871168 ON expansion_card_psuconnector (psuconnector_id)');
        $this->addSql('CREATE INDEX idx_99e2ca8696ec5e32 ON expansion_card_psuconnector (expansion_card_id)');
        $this->addSql('ALTER TABLE expansion_card_psuconnector ADD CONSTRAINT fk_99e2ca8696ec5e32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_psuconnector ADD CONSTRAINT fk_99e2ca86d6871168 FOREIGN KEY (psuconnector_id) REFERENCES psuconnector (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE expansion_card_power_connector_audit');
    }
}

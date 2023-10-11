<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231011185418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expansion_chip_type_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_768a399b2a26e0095ed53ebbc97ea803_idx ON expansion_chip_type_audit (type)');
        $this->addSql('CREATE INDEX object_id_768a399b2a26e0095ed53ebbc97ea803_idx ON expansion_chip_type_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_768a399b2a26e0095ed53ebbc97ea803_idx ON expansion_chip_type_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_768a399b2a26e0095ed53ebbc97ea803_idx ON expansion_chip_type_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_768a399b2a26e0095ed53ebbc97ea803_idx ON expansion_chip_type_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_768a399b2a26e0095ed53ebbc97ea803_idx ON expansion_chip_type_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_chip_type_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE expansion_chip_type_audit');
    }
}

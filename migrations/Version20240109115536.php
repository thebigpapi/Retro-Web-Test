<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109115536 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expansion_card_id_redirection (id INT NOT NULL, destination_id INT NOT NULL, expansion_card_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3A726AFB816C6140 ON expansion_card_id_redirection (destination_id)');
        $this->addSql('CREATE INDEX IDX_3A726AFB96EC5E32 ON expansion_card_id_redirection (expansion_card_id)');
        $this->addSql('CREATE TABLE expansion_card_id_redirection_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_4e19549b540829c938fb61cb0b120904_idx ON expansion_card_id_redirection_audit (type)');
        $this->addSql('CREATE INDEX object_id_4e19549b540829c938fb61cb0b120904_idx ON expansion_card_id_redirection_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_4e19549b540829c938fb61cb0b120904_idx ON expansion_card_id_redirection_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_4e19549b540829c938fb61cb0b120904_idx ON expansion_card_id_redirection_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_4e19549b540829c938fb61cb0b120904_idx ON expansion_card_id_redirection_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_4e19549b540829c938fb61cb0b120904_idx ON expansion_card_id_redirection_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_card_id_redirection_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE expansion_card_id_redirection ADD CONSTRAINT FK_3A726AFB816C6140 FOREIGN KEY (destination_id) REFERENCES expansion_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_id_redirection ADD CONSTRAINT FK_3A726AFB96EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_id_redirection ADD CONSTRAINT FK_3A726AFBBF396750 FOREIGN KEY (id) REFERENCES id_redirection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card ADD slug VARCHAR(80) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8795C2D6989D9B62 ON expansion_card (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expansion_card_id_redirection DROP CONSTRAINT FK_3A726AFB816C6140');
        $this->addSql('ALTER TABLE expansion_card_id_redirection DROP CONSTRAINT FK_3A726AFB96EC5E32');
        $this->addSql('ALTER TABLE expansion_card_id_redirection DROP CONSTRAINT FK_3A726AFBBF396750');
        $this->addSql('DROP TABLE expansion_card_id_redirection');
        $this->addSql('DROP TABLE expansion_card_id_redirection_audit');
        $this->addSql('DROP INDEX UNIQ_8795C2D6989D9B62');
        $this->addSql('ALTER TABLE expansion_card DROP slug');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109142945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_card_id_redirection DROP CONSTRAINT fk_3a726afb96ec5e32');
        $this->addSql('DROP INDEX idx_3a726afb96ec5e32');
        $this->addSql('ALTER TABLE expansion_card_id_redirection DROP expansion_card_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expansion_card_id_redirection ADD expansion_card_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_card_id_redirection ADD CONSTRAINT fk_3a726afb96ec5e32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3a726afb96ec5e32 ON expansion_card_id_redirection (expansion_card_id)');
    }
}

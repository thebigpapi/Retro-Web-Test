<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206222602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expansion_card_expansion_slot_signal (expansion_card_id INT NOT NULL, expansion_slot_signal_id INT NOT NULL, PRIMARY KEY(expansion_card_id, expansion_slot_signal_id))');
        $this->addSql('CREATE INDEX IDX_50F7C86496EC5E32 ON expansion_card_expansion_slot_signal (expansion_card_id)');
        $this->addSql('CREATE INDEX IDX_50F7C8646E6229F4 ON expansion_card_expansion_slot_signal (expansion_slot_signal_id)');
        $this->addSql('ALTER TABLE expansion_card_expansion_slot_signal ADD CONSTRAINT FK_50F7C86496EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_expansion_slot_signal ADD CONSTRAINT FK_50F7C8646E6229F4 FOREIGN KEY (expansion_slot_signal_id) REFERENCES expansion_slot_signal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card DROP CONSTRAINT fk_8795c2d66e6229f4');
        $this->addSql('DROP INDEX idx_8795c2d66e6229f4');
        $this->addSql('ALTER TABLE expansion_card DROP expansion_slot_signal_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expansion_card_expansion_slot_signal DROP CONSTRAINT FK_50F7C86496EC5E32');
        $this->addSql('ALTER TABLE expansion_card_expansion_slot_signal DROP CONSTRAINT FK_50F7C8646E6229F4');
        $this->addSql('DROP TABLE expansion_card_expansion_slot_signal');
        $this->addSql('ALTER TABLE expansion_card ADD expansion_slot_signal_id INT NOT NULL');
        $this->addSql('ALTER TABLE expansion_card ADD CONSTRAINT fk_8795c2d66e6229f4 FOREIGN KEY (expansion_slot_signal_id) REFERENCES expansion_slot_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8795c2d66e6229f4 ON expansion_card (expansion_slot_signal_id)');
    }
}

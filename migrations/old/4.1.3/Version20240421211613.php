<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240421211613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chip ADD type_id INT');
        $this->addSql('ALTER TABLE chip ADD CONSTRAINT FK_AA29BCBBC54C8C93 FOREIGN KEY (type_id) REFERENCES expansion_chip_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_AA29BCBBC54C8C93 ON chip (type_id)');
        $this->addSql('ALTER TABLE expansion_chip DROP CONSTRAINT fk_3ba8e6bec54c8c93');
        $this->addSql('UPDATE chip SET type_id=ec.type_id FROM expansion_chip ec WHERE ec.id=chip.id');
        $this->addSql('UPDATE chip SET type_id=10 FROM processing_unit p WHERE p.id=chip.id');
        $this->addSql('DROP INDEX idx_3ba8e6bec54c8c93');
        //$this->addSql('ALTER TABLE chip ALTER COLUMN type_id SET NOT NULL'); //broken due to "recycle" expansion chips
        $this->addSql('ALTER TABLE expansion_chip DROP type_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chip DROP CONSTRAINT FK_AA29BCBBC54C8C93');
        $this->addSql('DROP INDEX IDX_AA29BCBBC54C8C93');
        $this->addSql('ALTER TABLE chip DROP type_id');
        $this->addSql('ALTER TABLE expansion_chip ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE expansion_chip ADD CONSTRAINT fk_3ba8e6bec54c8c93 FOREIGN KEY (type_id) REFERENCES expansion_chip_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3ba8e6bec54c8c93 ON expansion_chip (type_id)');
    }
}

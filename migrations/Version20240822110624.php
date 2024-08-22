<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240822110624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instruction_set_instruction_set DROP CONSTRAINT fk_a5925a66e53a5cf8');
        $this->addSql('ALTER TABLE instruction_set_instruction_set DROP CONSTRAINT fk_a5925a66fcdf0c77');
        $this->addSql('DROP TABLE instruction_set_instruction_set');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE instruction_set_instruction_set (instruction_set_source INT NOT NULL, instruction_set_target INT NOT NULL, PRIMARY KEY(instruction_set_source, instruction_set_target))');
        $this->addSql('CREATE INDEX idx_a5925a66fcdf0c77 ON instruction_set_instruction_set (instruction_set_source)');
        $this->addSql('CREATE INDEX idx_a5925a66e53a5cf8 ON instruction_set_instruction_set (instruction_set_target)');
        $this->addSql('ALTER TABLE instruction_set_instruction_set ADD CONSTRAINT fk_a5925a66e53a5cf8 FOREIGN KEY (instruction_set_target) REFERENCES instruction_set (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE instruction_set_instruction_set ADD CONSTRAINT fk_a5925a66fcdf0c77 FOREIGN KEY (instruction_set_source) REFERENCES instruction_set (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}

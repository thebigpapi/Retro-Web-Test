<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210305004134 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE instruction_set_processing_unit (instruction_set_id INT NOT NULL, processing_unit_id INT NOT NULL, PRIMARY KEY(instruction_set_id, processing_unit_id))');
        $this->addSql('CREATE INDEX IDX_8E24BE71929CC919 ON instruction_set_processing_unit (instruction_set_id)');
        $this->addSql('CREATE INDEX IDX_8E24BE7193E55C96 ON instruction_set_processing_unit (processing_unit_id)');
        $this->addSql('ALTER TABLE instruction_set_processing_unit ADD CONSTRAINT FK_8E24BE71929CC919 FOREIGN KEY (instruction_set_id) REFERENCES instruction_set (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE instruction_set_processing_unit ADD CONSTRAINT FK_8E24BE7193E55C96 FOREIGN KEY (processing_unit_id) REFERENCES processing_unit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE processing_unit_instruction_set');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE processing_unit_instruction_set (processing_unit_id INT NOT NULL, instruction_set_id INT NOT NULL, PRIMARY KEY(processing_unit_id, instruction_set_id))');
        $this->addSql('CREATE INDEX idx_bc59580093e55c96 ON processing_unit_instruction_set (processing_unit_id)');
        $this->addSql('CREATE INDEX idx_bc595800929cc919 ON processing_unit_instruction_set (instruction_set_id)');
        $this->addSql('ALTER TABLE processing_unit_instruction_set ADD CONSTRAINT fk_bc59580093e55c96 FOREIGN KEY (processing_unit_id) REFERENCES processing_unit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit_instruction_set ADD CONSTRAINT fk_bc595800929cc919 FOREIGN KEY (instruction_set_id) REFERENCES instruction_set (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE instruction_set_processing_unit');
    }
}

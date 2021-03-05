<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304233231 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE processing_unit_instruction_set (processing_unit_id INT NOT NULL, instruction_set_id INT NOT NULL, PRIMARY KEY(processing_unit_id, instruction_set_id))');
        $this->addSql('CREATE INDEX IDX_BC59580093E55C96 ON processing_unit_instruction_set (processing_unit_id)');
        $this->addSql('CREATE INDEX IDX_BC595800929CC919 ON processing_unit_instruction_set (instruction_set_id)');
        $this->addSql('ALTER TABLE processing_unit_instruction_set ADD CONSTRAINT FK_BC59580093E55C96 FOREIGN KEY (processing_unit_id) REFERENCES processing_unit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit_instruction_set ADD CONSTRAINT FK_BC595800929CC919 FOREIGN KEY (instruction_set_id) REFERENCES instruction_set (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit DROP CONSTRAINT fk_1f72dc5e929cc919');
        $this->addSql('DROP INDEX idx_1f72dc5e929cc919');
        $this->addSql('ALTER TABLE processing_unit DROP instruction_set_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE processing_unit_instruction_set');
        $this->addSql('ALTER TABLE processing_unit ADD instruction_set_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processing_unit ADD CONSTRAINT fk_1f72dc5e929cc919 FOREIGN KEY (instruction_set_id) REFERENCES instruction_set (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1f72dc5e929cc919 ON processing_unit (instruction_set_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307100201 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE instruction_set_instruction_set (instruction_set_source INT NOT NULL, instruction_set_target INT NOT NULL, PRIMARY KEY(instruction_set_source, instruction_set_target))');
        $this->addSql('CREATE INDEX IDX_A5925A66FCDF0C77 ON instruction_set_instruction_set (instruction_set_source)');
        $this->addSql('CREATE INDEX IDX_A5925A66E53A5CF8 ON instruction_set_instruction_set (instruction_set_target)');
        $this->addSql('ALTER TABLE instruction_set_instruction_set ADD CONSTRAINT FK_A5925A66FCDF0C77 FOREIGN KEY (instruction_set_source) REFERENCES instruction_set (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE instruction_set_instruction_set ADD CONSTRAINT FK_A5925A66E53A5CF8 FOREIGN KEY (instruction_set_target) REFERENCES instruction_set (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE instruction_set DROP CONSTRAINT fk_34c438493675e72');
        $this->addSql('DROP INDEX idx_34c438493675e72');
        $this->addSql('ALTER TABLE instruction_set DROP compatible_with_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE instruction_set_instruction_set');
        $this->addSql('ALTER TABLE instruction_set ADD compatible_with_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE instruction_set ADD CONSTRAINT fk_34c438493675e72 FOREIGN KEY (compatible_with_id) REFERENCES instruction_set (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_34c438493675e72 ON instruction_set (compatible_with_id)');
    }
}

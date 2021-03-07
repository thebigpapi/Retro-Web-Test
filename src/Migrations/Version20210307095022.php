<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307095022 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE instruction_set_compatiblity_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE instruction_set_compatiblity (id INT NOT NULL, old_id INT NOT NULL, new_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AD92710039E6FA16 ON instruction_set_compatiblity (old_id)');
        $this->addSql('CREATE INDEX IDX_AD927100BD06B3B3 ON instruction_set_compatiblity (new_id)');
        $this->addSql('ALTER TABLE instruction_set_compatiblity ADD CONSTRAINT FK_AD92710039E6FA16 FOREIGN KEY (old_id) REFERENCES instruction_set (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE instruction_set_compatiblity ADD CONSTRAINT FK_AD927100BD06B3B3 FOREIGN KEY (new_id) REFERENCES instruction_set (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE instruction_set_compatiblity_id_seq CASCADE');
        $this->addSql('DROP TABLE instruction_set_compatiblity');
    }
}

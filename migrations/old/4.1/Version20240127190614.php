<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240127190614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE large_file DROP CONSTRAINT fk_8c8cd216398716cd');
        $this->addSql('DROP SEQUENCE dump_quality_flag_id_seq CASCADE');
        $this->addSql('ALTER TABLE large_file_language DROP CONSTRAINT fk_473d2a6a29ea72e8');
        $this->addSql('ALTER TABLE large_file_language DROP CONSTRAINT fk_473d2a6a82f1baf4');
        $this->addSql('DROP TABLE dump_quality_flag');
        $this->addSql('DROP TABLE large_file_language');
        $this->addSql('DROP INDEX idx_8c8cd216398716cd');
        $this->addSql('ALTER TABLE large_file DROP dump_quality_flag_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE dump_quality_flag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE dump_quality_flag (id INT NOT NULL, name VARCHAR(255) NOT NULL, tag_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE large_file_language (large_file_id INT NOT NULL, language_id INT NOT NULL, PRIMARY KEY(large_file_id, language_id))');
        $this->addSql('CREATE INDEX idx_473d2a6a82f1baf4 ON large_file_language (language_id)');
        $this->addSql('CREATE INDEX idx_473d2a6a29ea72e8 ON large_file_language (large_file_id)');
        $this->addSql('ALTER TABLE large_file_language ADD CONSTRAINT fk_473d2a6a29ea72e8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_language ADD CONSTRAINT fk_473d2a6a82f1baf4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file ADD dump_quality_flag_id INT NOT NULL');
        $this->addSql('ALTER TABLE large_file ADD CONSTRAINT fk_8c8cd216398716cd FOREIGN KEY (dump_quality_flag_id) REFERENCES dump_quality_flag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8c8cd216398716cd ON large_file (dump_quality_flag_id)');
    }
}

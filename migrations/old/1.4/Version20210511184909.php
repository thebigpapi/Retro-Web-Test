<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511184909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE large_file_language (large_file_id INT NOT NULL, language_id INT NOT NULL, PRIMARY KEY(large_file_id, language_id))');
        $this->addSql('CREATE INDEX IDX_473D2A6A29EA72E8 ON large_file_language (large_file_id)');
        $this->addSql('CREATE INDEX IDX_473D2A6A82F1BAF4 ON large_file_language (language_id)');
        $this->addSql('ALTER TABLE large_file_language ADD CONSTRAINT FK_473D2A6A29EA72E8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_language ADD CONSTRAINT FK_473D2A6A82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file ADD dump_quality_flag_id INT NOT NULL');
        $this->addSql('ALTER TABLE large_file ADD subdirectory VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE large_file ADD file_version VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE large_file ADD CONSTRAINT FK_8C8CD216398716CD FOREIGN KEY (dump_quality_flag_id) REFERENCES dump_quality_flag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8C8CD216398716CD ON large_file (dump_quality_flag_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE large_file_language');
        $this->addSql('ALTER TABLE large_file DROP CONSTRAINT FK_8C8CD216398716CD');
        $this->addSql('DROP INDEX IDX_8C8CD216398716CD');
        $this->addSql('ALTER TABLE large_file DROP dump_quality_flag_id');
        $this->addSql('ALTER TABLE large_file DROP subdirectory');
        $this->addSql('ALTER TABLE large_file DROP file_version');
    }
}

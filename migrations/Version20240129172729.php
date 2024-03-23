<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240129172729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cpuid_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cpuid (id INT NOT NULL, processor_platform_type_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DF558508A90B5CBC ON cpuid (processor_platform_type_id)');
        $this->addSql('ALTER TABLE cpuid ADD CONSTRAINT FK_DF558508A90B5CBC FOREIGN KEY (processor_platform_type_id) REFERENCES processor_platform_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE cpuid_id_seq CASCADE');
        $this->addSql('ALTER TABLE cpuid DROP CONSTRAINT FK_DF558508A90B5CBC');
        $this->addSql('DROP TABLE cpuid');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240822101440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE cpuid_id_seq CASCADE');
        $this->addSql('ALTER TABLE cpuid DROP CONSTRAINT fk_df558508a90b5cbc');
        $this->addSql('DROP TABLE cpuid');
        $this->addSql('ALTER TABLE processor_platform_type DROP process_node');
        $this->addSql('ALTER TABLE processor_platform_type DROP l1code_ratio');
        $this->addSql('ALTER TABLE processor_platform_type DROP l1data_ratio');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE cpuid_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cpuid (id INT NOT NULL, processor_platform_type_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_df558508a90b5cbc ON cpuid (processor_platform_type_id)');
        $this->addSql('ALTER TABLE cpuid ADD CONSTRAINT fk_df558508a90b5cbc FOREIGN KEY (processor_platform_type_id) REFERENCES processor_platform_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor_platform_type ADD process_node INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor_platform_type ADD l1code_ratio DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE processor_platform_type ADD l1data_ratio DOUBLE PRECISION NOT NULL');
    }
}

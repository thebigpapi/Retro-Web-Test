<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024183406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE processor_platform_type_dram_type (processor_platform_type_id INT NOT NULL, dram_type_id INT NOT NULL, PRIMARY KEY(processor_platform_type_id, dram_type_id))');
        $this->addSql('CREATE INDEX IDX_83AF01B9A90B5CBC ON processor_platform_type_dram_type (processor_platform_type_id)');
        $this->addSql('CREATE INDEX IDX_83AF01B9B1E0C110 ON processor_platform_type_dram_type (dram_type_id)');
        $this->addSql('ALTER TABLE processor_platform_type_dram_type ADD CONSTRAINT FK_83AF01B9A90B5CBC FOREIGN KEY (processor_platform_type_id) REFERENCES processor_platform_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor_platform_type_dram_type ADD CONSTRAINT FK_83AF01B9B1E0C110 FOREIGN KEY (dram_type_id) REFERENCES dram_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor_platform_type DROP has_imc');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE processor_platform_type_dram_type DROP CONSTRAINT FK_83AF01B9A90B5CBC');
        $this->addSql('ALTER TABLE processor_platform_type_dram_type DROP CONSTRAINT FK_83AF01B9B1E0C110');
        $this->addSql('DROP TABLE processor_platform_type_dram_type');
        $this->addSql('ALTER TABLE processor_platform_type ADD has_imc BOOLEAN DEFAULT NULL');
    }
}

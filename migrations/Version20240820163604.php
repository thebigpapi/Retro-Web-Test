<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820163604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chip ALTER part_number DROP NOT NULL');
        $this->addSql('ALTER TABLE processor_platform_type DROP CONSTRAINT fk_30909c82af8f1494');
        $this->addSql('ALTER TABLE processor_platform_type DROP CONSTRAINT fk_30909c82bfa04bbf');
        $this->addSql('DROP INDEX idx_30909c82bfa04bbf');
        $this->addSql('DROP INDEX idx_30909c82af8f1494');
        $this->addSql('ALTER TABLE processor_platform_type DROP l1data_id');
        $this->addSql('ALTER TABLE processor_platform_type DROP l1code_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE processor_platform_type ADD l1data_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor_platform_type ADD l1code_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor_platform_type ADD CONSTRAINT fk_30909c82af8f1494 FOREIGN KEY (l1code_id) REFERENCES cache_size (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor_platform_type ADD CONSTRAINT fk_30909c82bfa04bbf FOREIGN KEY (l1data_id) REFERENCES cache_size (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_30909c82bfa04bbf ON processor_platform_type (l1data_id)');
        $this->addSql('CREATE INDEX idx_30909c82af8f1494 ON processor_platform_type (l1code_id)');
        $this->addSql('ALTER TABLE chip ALTER part_number SET NOT NULL');
    }
}

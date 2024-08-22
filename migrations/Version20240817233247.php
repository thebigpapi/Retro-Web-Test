<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240817233247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        /*$this->addSql('ALTER TABLE processor_platform_type ADD misc_specs JSONB');
        $this->addSql('UPDATE processor_platform_type SET misc_specs=\'[]\' ');
        $this->addSql('ALTER TABLE processor_platform_type ALTER misc_specs SET NOT NULL');*/
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        /*$this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE processor_platform_type DROP misc_specs');*/
    }
}

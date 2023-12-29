<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231229164623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chip_documentation ADD release_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE chip_documentation ADD date_precision VARCHAR(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE manual ADD release_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE manual ADD date_precision VARCHAR(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE storage_device_documentation ADD release_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE storage_device_documentation ADD date_precision VARCHAR(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE chipset_documentation ADD release_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE chipset_documentation ADD date_precision VARCHAR(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE manual DROP release_date');
        $this->addSql('ALTER TABLE manual DROP date_precision');
        $this->addSql('ALTER TABLE storage_device_documentation DROP release_date');
        $this->addSql('ALTER TABLE storage_device_documentation DROP date_precision');
        $this->addSql('ALTER TABLE chip_documentation DROP release_date');
        $this->addSql('ALTER TABLE chip_documentation DROP date_precision');
        $this->addSql('ALTER TABLE chipset_documentation DROP release_date');
        $this->addSql('ALTER TABLE chipset_documentation DROP date_precision');
    }
}

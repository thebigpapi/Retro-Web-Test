<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922154752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chip_image DROP CONSTRAINT fk_e3ead662460f904b');
        $this->addSql('DROP INDEX idx_e3ead662460f904b');
        $this->addSql('ALTER TABLE chip_image DROP license_id');
        $this->addSql('ALTER TABLE motherboard_image DROP CONSTRAINT fk_fb11e572460f904b');
        $this->addSql('DROP INDEX idx_fb11e572460f904b');
        $this->addSql('ALTER TABLE motherboard_image DROP license_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chip_image ADD license_id INT NOT NULL');
        $this->addSql('ALTER TABLE chip_image ADD CONSTRAINT fk_e3ead662460f904b FOREIGN KEY (license_id) REFERENCES license (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_e3ead662460f904b ON chip_image (license_id)');
        $this->addSql('ALTER TABLE motherboard_image ADD license_id INT NOT NULL');
        $this->addSql('ALTER TABLE motherboard_image ADD CONSTRAINT fk_fb11e572460f904b FOREIGN KEY (license_id) REFERENCES license (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_fb11e572460f904b ON motherboard_image (license_id)');
    }
}

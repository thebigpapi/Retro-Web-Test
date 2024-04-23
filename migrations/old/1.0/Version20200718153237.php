<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200718153237 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE motherboard_image ADD license_id INT NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE motherboard_image ADD CONSTRAINT FK_FB11E572460F904B FOREIGN KEY (license_id) REFERENCES license (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FB11E572460F904B ON motherboard_image (license_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE motherboard_image DROP CONSTRAINT FK_FB11E572460F904B');
        $this->addSql('DROP INDEX IDX_FB11E572460F904B');
        $this->addSql('ALTER TABLE motherboard_image DROP license_id');
    }
}

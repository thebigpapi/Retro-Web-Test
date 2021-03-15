<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210306203008 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE chip RENAME COLUMN chip_no TO part_number');
        $this->addSql('ALTER TABLE chip_alias ADD manufacturer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chip_alias ADD name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE chip_alias ADD part_number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE chip_alias ADD CONSTRAINT FK_C7BBB9A9A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C7BBB9A9A23B42D ON chip_alias (manufacturer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chip RENAME COLUMN part_number TO chip_no');
        $this->addSql('ALTER TABLE chip_alias DROP CONSTRAINT FK_C7BBB9A9A23B42D');
        $this->addSql('DROP INDEX IDX_C7BBB9A9A23B42D');
        $this->addSql('ALTER TABLE chip_alias DROP manufacturer_id');
        $this->addSql('ALTER TABLE chip_alias DROP name');
        $this->addSql('ALTER TABLE chip_alias DROP part_number');
    }
}

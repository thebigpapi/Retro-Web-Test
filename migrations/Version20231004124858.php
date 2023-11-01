<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231004124858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coprocessor DROP CONSTRAINT fk_4d944cd6bf396750');
        $this->addSql('DROP TABLE coprocessor');
        $this->addSql('ALTER TABLE hard_drive ADD buffer INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hard_drive ADD random_seek DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE hard_drive ADD track_seek DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE storage_device DROP CONSTRAINT fk_322c428fab0be982');
        $this->addSql('DROP INDEX idx_322c428fab0be982');
        $this->addSql('ALTER TABLE storage_device DROP interface_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE coprocessor (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE coprocessor ADD CONSTRAINT fk_4d944cd6bf396750 FOREIGN KEY (id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hard_drive DROP buffer');
        $this->addSql('ALTER TABLE hard_drive DROP random_seek');
        $this->addSql('ALTER TABLE hard_drive DROP track_seek');
        $this->addSql('ALTER TABLE storage_device ADD interface_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE storage_device ADD CONSTRAINT fk_322c428fab0be982 FOREIGN KEY (interface_id) REFERENCES storage_device_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_322c428fab0be982 ON storage_device (interface_id)');
    }
}

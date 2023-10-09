<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231004172245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE storage_device_storage_device_interface (storage_device_id INT NOT NULL, storage_device_interface_id INT NOT NULL, PRIMARY KEY(storage_device_id, storage_device_interface_id))');
        $this->addSql('CREATE INDEX IDX_F9E677B17CBFD8DB ON storage_device_storage_device_interface (storage_device_id)');
        $this->addSql('CREATE INDEX IDX_F9E677B14A921D73 ON storage_device_storage_device_interface (storage_device_interface_id)');
        $this->addSql('ALTER TABLE storage_device_storage_device_interface ADD CONSTRAINT FK_F9E677B17CBFD8DB FOREIGN KEY (storage_device_id) REFERENCES storage_device (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device_storage_device_interface ADD CONSTRAINT FK_F9E677B14A921D73 FOREIGN KEY (storage_device_interface_id) REFERENCES storage_device_interface (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE storage_device_storage_device_interface DROP CONSTRAINT FK_F9E677B17CBFD8DB');
        $this->addSql('ALTER TABLE storage_device_storage_device_interface DROP CONSTRAINT FK_F9E677B14A921D73');
        $this->addSql('DROP TABLE storage_device_storage_device_interface');
    }
}

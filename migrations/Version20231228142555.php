<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231228142555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE storage_device_psuconnector (storage_device_id INT NOT NULL, psuconnector_id INT NOT NULL, PRIMARY KEY(storage_device_id, psuconnector_id))');
        $this->addSql('CREATE INDEX IDX_3B2398847CBFD8DB ON storage_device_psuconnector (storage_device_id)');
        $this->addSql('CREATE INDEX IDX_3B239884D6871168 ON storage_device_psuconnector (psuconnector_id)');
        $this->addSql('ALTER TABLE storage_device_psuconnector ADD CONSTRAINT FK_3B2398847CBFD8DB FOREIGN KEY (storage_device_id) REFERENCES storage_device (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device_psuconnector ADD CONSTRAINT FK_3B239884D6871168 FOREIGN KEY (psuconnector_id) REFERENCES psuconnector (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE storage_device_psuconnector DROP CONSTRAINT FK_3B2398847CBFD8DB');
        $this->addSql('ALTER TABLE storage_device_psuconnector DROP CONSTRAINT FK_3B239884D6871168');
        $this->addSql('DROP TABLE storage_device_psuconnector');
    }
}

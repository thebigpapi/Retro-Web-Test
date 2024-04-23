<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231025213818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE storage_device_id_redirection (id INT NOT NULL, destination_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D219A60816C6140 ON storage_device_id_redirection (destination_id)');
        $this->addSql('ALTER TABLE storage_device_id_redirection ADD CONSTRAINT FK_8D219A60816C6140 FOREIGN KEY (destination_id) REFERENCES storage_device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device_id_redirection ADD CONSTRAINT FK_8D219A60BF396750 FOREIGN KEY (id) REFERENCES id_redirection (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE storage_device_id_redirection DROP CONSTRAINT FK_8D219A60816C6140');
        $this->addSql('ALTER TABLE storage_device_id_redirection DROP CONSTRAINT FK_8D219A60BF396750');
        $this->addSql('DROP TABLE storage_device_id_redirection');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617005421 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE chipset_chipset_part');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE chipset_chipset_part (index INT NOT NULL, chipset_id INT NOT NULL, chipset_part_id INT NOT NULL, PRIMARY KEY(chipset_id, chipset_part_id, index))');
        $this->addSql('CREATE INDEX idx_1d67f57836f0f0c7 ON chipset_chipset_part (chipset_part_id)');
        $this->addSql('CREATE INDEX idx_1d67f578bc1433b9 ON chipset_chipset_part (chipset_id)');
        $this->addSql('ALTER TABLE chipset_chipset_part ADD CONSTRAINT fk_1d67f578bc1433b9 FOREIGN KEY (chipset_id) REFERENCES chipset (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_chipset_part ADD CONSTRAINT fk_1d67f57836f0f0c7 FOREIGN KEY (chipset_part_id) REFERENCES chipset_part (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}

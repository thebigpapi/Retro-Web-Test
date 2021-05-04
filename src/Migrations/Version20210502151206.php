<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210502151206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE chipset_bios_code_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE chipset_bios_code (id INT NOT NULL, chipset_id INT NOT NULL, bios_manufacturer_id INT NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6DA11F9FBC1433B9 ON chipset_bios_code (chipset_id)');
        $this->addSql('CREATE INDEX IDX_6DA11F9FE209FBA6 ON chipset_bios_code (bios_manufacturer_id)');
        $this->addSql('ALTER TABLE chipset_bios_code ADD CONSTRAINT FK_6DA11F9FBC1433B9 FOREIGN KEY (chipset_id) REFERENCES chipset (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_bios_code ADD CONSTRAINT FK_6DA11F9FE209FBA6 FOREIGN KEY (bios_manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE chipset_bios_code_id_seq CASCADE');
        $this->addSql('DROP TABLE chipset_bios_code');
    }
}

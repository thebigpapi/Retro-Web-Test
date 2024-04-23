<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222142806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE expansion_card_power_connector_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_card_power_connector (id INT NOT NULL, power_connector_id INT NOT NULL, expansion_card_id INT NOT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4A0BEB045B148B5C ON expansion_card_power_connector (power_connector_id)');
        $this->addSql('CREATE INDEX IDX_4A0BEB0496EC5E32 ON expansion_card_power_connector (expansion_card_id)');
        $this->addSql('ALTER TABLE expansion_card_power_connector ADD CONSTRAINT FK_4A0BEB045B148B5C FOREIGN KEY (power_connector_id) REFERENCES psuconnector (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_power_connector ADD CONSTRAINT FK_4A0BEB0496EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_bios ADD hash VARCHAR(255) DEFAULT NULL');
        $this->addSql("ALTER TABLE expansion_chip_type ADD template JSON DEFAULT '[]' NOT NULL");
        $this->addSql('ALTER TABLE expansion_chip_type ALTER template DROP DEFAULT');
        $this->addSql('ALTER TABLE expansion_slot_interface ADD part_number VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE io_port_interface ADD part_number VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE expansion_card_power_connector_id_seq CASCADE');
        $this->addSql('ALTER TABLE expansion_card_power_connector DROP CONSTRAINT FK_4A0BEB045B148B5C');
        $this->addSql('ALTER TABLE expansion_card_power_connector DROP CONSTRAINT FK_4A0BEB0496EC5E32');
        $this->addSql('DROP TABLE expansion_card_power_connector');
        $this->addSql('ALTER TABLE expansion_card_bios DROP hash');
        $this->addSql('ALTER TABLE io_port_interface DROP part_number');
        $this->addSql('ALTER TABLE expansion_slot_interface DROP part_number');
        $this->addSql('ALTER TABLE expansion_chip_type DROP template');
    }
}

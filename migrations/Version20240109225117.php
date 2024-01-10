<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109225117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE expansion_card_memory_connector_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_card_dram_type (expansion_card_id INT NOT NULL, dram_type_id INT NOT NULL, PRIMARY KEY(expansion_card_id, dram_type_id))');
        $this->addSql('CREATE INDEX IDX_24F2C22596EC5E32 ON expansion_card_dram_type (expansion_card_id)');
        $this->addSql('CREATE INDEX IDX_24F2C225B1E0C110 ON expansion_card_dram_type (dram_type_id)');
        $this->addSql('CREATE TABLE expansion_card_max_ram (expansion_card_id INT NOT NULL, max_ram_id INT NOT NULL, PRIMARY KEY(expansion_card_id, max_ram_id))');
        $this->addSql('CREATE INDEX IDX_572C9A5596EC5E32 ON expansion_card_max_ram (expansion_card_id)');
        $this->addSql('CREATE INDEX IDX_572C9A559457A0E1 ON expansion_card_max_ram (max_ram_id)');
        $this->addSql('CREATE TABLE expansion_card_memory_connector (id INT NOT NULL, expansion_card_id INT NOT NULL, memory_connector_id INT NOT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9CB82F0F96EC5E32 ON expansion_card_memory_connector (expansion_card_id)');
        $this->addSql('CREATE INDEX IDX_9CB82F0FA1AA202C ON expansion_card_memory_connector (memory_connector_id)');
        $this->addSql('ALTER TABLE expansion_card_dram_type ADD CONSTRAINT FK_24F2C22596EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_dram_type ADD CONSTRAINT FK_24F2C225B1E0C110 FOREIGN KEY (dram_type_id) REFERENCES dram_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_max_ram ADD CONSTRAINT FK_572C9A5596EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_max_ram ADD CONSTRAINT FK_572C9A559457A0E1 FOREIGN KEY (max_ram_id) REFERENCES max_ram (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_memory_connector ADD CONSTRAINT FK_9CB82F0F96EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_memory_connector ADD CONSTRAINT FK_9CB82F0FA1AA202C FOREIGN KEY (memory_connector_id) REFERENCES memory_connector (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE expansion_card_memory_connector_id_seq CASCADE');
        $this->addSql('ALTER TABLE expansion_card_dram_type DROP CONSTRAINT FK_24F2C22596EC5E32');
        $this->addSql('ALTER TABLE expansion_card_dram_type DROP CONSTRAINT FK_24F2C225B1E0C110');
        $this->addSql('ALTER TABLE expansion_card_max_ram DROP CONSTRAINT FK_572C9A5596EC5E32');
        $this->addSql('ALTER TABLE expansion_card_max_ram DROP CONSTRAINT FK_572C9A559457A0E1');
        $this->addSql('ALTER TABLE expansion_card_memory_connector DROP CONSTRAINT FK_9CB82F0F96EC5E32');
        $this->addSql('ALTER TABLE expansion_card_memory_connector DROP CONSTRAINT FK_9CB82F0FA1AA202C');
        $this->addSql('DROP TABLE expansion_card_dram_type');
        $this->addSql('DROP TABLE expansion_card_max_ram');
        $this->addSql('DROP TABLE expansion_card_memory_connector');
    }
}

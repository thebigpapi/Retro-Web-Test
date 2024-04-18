<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230121183357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //Temp tables
        $this->addSql('CREATE TEMP TABLE expansionch AS SELECT * FROM expansion_chip');
        $this->addSql('CREATE TEMP TABLE mbexpansionch AS SELECT * FROM motherboard_expansion_chip');
        $this->addSql('CREATE TEMP TABLE lgexpansionch AS SELECT * FROM large_file_expansion_chip');
        $this->addSql('UPDATE expansionch set id=id+(SELECT max(id) FROM chip)');
        $this->addSql('UPDATE mbexpansionch set expansion_chip_id=expansion_chip_id+(SELECT max(id) FROM chip)');
        $this->addSql('UPDATE lgexpansionch set expansion_chip_id=expansion_chip_id+(SELECT max(id) FROM chip)');
        $this->addSql('DELETE FROM motherboard_expansion_chip');
        $this->addSql('DELETE FROM large_file_expansion_chip');
        $this->addSql('DELETE FROM expansion_chip');

        //Adding data to chip table
        $this->addSql("INSERT INTO chip (id, manufacturer_id, name, part_number, dtype ) SELECT id, manufacturer_id, name, COALESCE(chip_name, 'n/a'), 'expansionchip' FROM expansionch");

        //Updating structures
        $this->addSql('DROP SEQUENCE expansion_chip_id_seq CASCADE');
        $this->addSql('ALTER TABLE expansion_chip DROP CONSTRAINT fk_3ba8e6bea23b42d');
        $this->addSql('DROP INDEX idx_3ba8e6bea23b42d');
        $this->addSql('ALTER TABLE expansion_chip DROP manufacturer_id');
        $this->addSql('ALTER TABLE expansion_chip DROP name');
        $this->addSql('ALTER TABLE expansion_chip DROP chip_name');

        //Adding the data back to the tables
        $this->addSql("INSERT INTO expansion_chip (id, type_id) SELECT id, type_id FROM expansionch");
        $this->addSql('INSERT INTO motherboard_expansion_chip (motherboard_id, expansion_chip_id) SELECT motherboard_id, expansion_chip_id FROM mbexpansionch');
        $this->addSql('INSERT INTO large_file_expansion_chip (id, large_file_id, expansion_chip_id, is_recommended) SELECT id, large_file_id, expansion_chip_id, is_recommended FROM lgexpansionch');
        $this->addSql('ALTER TABLE expansion_chip ADD CONSTRAINT FK_3BA8E6BEBF396750 FOREIGN KEY (id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE expansion_chip_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE expansion_chip DROP CONSTRAINT FK_3BA8E6BEBF396750');
        $this->addSql('ALTER TABLE expansion_chip ADD manufacturer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_chip ADD name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_chip ADD chip_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_chip ADD CONSTRAINT fk_3ba8e6bea23b42d FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3ba8e6bea23b42d ON expansion_chip (manufacturer_id)');
    }
}

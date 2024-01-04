<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914141255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

	$this->addSql("
	    DO
	    $$
	    DECLARE
	        amstrad_id INT;
	        winco_id INT;
	    BEGIN
	        SELECT MIN(id) INTO amstrad_id FROM manufacturer WHERE name = 'Amstrad';
	        SELECT MIN(id) INTO winco_id FROM manufacturer WHERE name = 'Winco';

	        IF amstrad_id IS NOT NULL THEN
	            UPDATE chip SET manufacturer_id = amstrad_id WHERE manufacturer_id IN (SELECT id FROM manufacturer WHERE name = 'Amstrad');
	        END IF;

	        IF winco_id IS NOT NULL THEN
	            UPDATE chip SET manufacturer_id = winco_id WHERE manufacturer_id IN (SELECT id FROM manufacturer WHERE name = 'Winco');
	        END IF;

		IF amstrad_id IS NOT NULL THEN
	            UPDATE chipset SET manufacturer_id = amstrad_id WHERE manufacturer_id IN (SELECT id FROM manufacturer WHERE name = 'Amstrad');
	        END IF;

	        IF winco_id IS NOT NULL THEN
	            UPDATE chipset SET manufacturer_id = winco_id WHERE manufacturer_id IN (SELECT id FROM manufacturer WHERE name = 'Winco');
	        END IF;
	    END
	    $$;
	");

	$this->addSql("
	    DELETE FROM manufacturer
	    WHERE name IN ('Amstrad', 'Winco')
	    AND id NOT IN (
	        SELECT MIN(id) FROM manufacturer WHERE name IN ('Amstrad', 'Winco') GROUP BY name
	    );
	");
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chipset_expansion_chip (chipset_id INT NOT NULL, expansion_chip_id INT NOT NULL, PRIMARY KEY(chipset_id, expansion_chip_id))');
        $this->addSql('CREATE INDEX IDX_A5DDC5C4BC1433B9 ON chipset_expansion_chip (chipset_id)');
        $this->addSql('CREATE INDEX IDX_A5DDC5C479A869A1 ON chipset_expansion_chip (expansion_chip_id)');
        $this->addSql('ALTER TABLE chipset_expansion_chip ADD CONSTRAINT FK_A5DDC5C4BC1433B9 FOREIGN KEY (chipset_id) REFERENCES chipset (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_expansion_chip ADD CONSTRAINT FK_A5DDC5C479A869A1 FOREIGN KEY (expansion_chip_id) REFERENCES expansion_chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        //$this->addSql('CREATE TEMP TABLE chpart AS SELECT * FROM chipset_part');
        $this->addSql("UPDATE chip SET dtype='expansionchip' WHERE dtype='chipsetpart'");
        $this->addSql("ALTER TABLE expansion_chip ALTER description TYPE VARCHAR(8192)");
        $this->addSql("INSERT INTO expansion_chip_type(id, name) VALUES (30, 'Chipset Part')");
        $this->addSql('INSERT INTO expansion_chip(id, type_id, description) SELECT id, 30, description FROM chipset_part');
        $this->addSql('INSERT INTO chipset_expansion_chip(chipset_id, expansion_chip_id) SELECT chipset_id, chipset_part_id FROM chipset_chipset_part');
        // start deleting shit
        $this->addSql('ALTER TABLE chipset_chipset_part DROP CONSTRAINT fk_1d67f57836f0f0c7');
        $this->addSql('ALTER TABLE chipset_chipset_part DROP CONSTRAINT fk_1d67f578bc1433b9');
        $this->addSql('DROP TABLE chipset_chipset_part');
        $this->addSql('ALTER TABLE chipset_part DROP description');
        $this->addSql('ALTER TABLE chipset_part DROP rank');
        $this->addSql('DROP TABLE chipset_part CASCADE');
        $this->addSql('DROP SEQUENCE large_file_chipset_part_id_seq CASCADE');
        $this->addSql('ALTER TABLE large_file_chipset_part DROP CONSTRAINT fk_d54950a929ea72e8');
        $this->addSql('DROP TABLE large_file_chipset_part');
//        $this->addSql('DROP INDEX uniq_3d0ae6dc3ee4b093');
//       $this->addSql('DROP INDEX uniq_3d0ae6dc5e237e06');
        $this->addSql('DROP INDEX UNIQ_3D0AE6DC5E237E06');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D0AE6DCDBC463C4 ON manufacturer (full_name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D0AE6DC5E237E06 ON manufacturer (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE chipset_chipset_part (chipset_id INT NOT NULL, chipset_part_id INT NOT NULL, PRIMARY KEY(chipset_id, chipset_part_id))');
        $this->addSql('CREATE INDEX idx_1d67f578bc1433b9 ON chipset_chipset_part (chipset_id)');
        $this->addSql('CREATE INDEX idx_1d67f57836f0f0c7 ON chipset_chipset_part (chipset_part_id)');
        $this->addSql('ALTER TABLE chipset_chipset_part ADD CONSTRAINT fk_1d67f57836f0f0c7 FOREIGN KEY (chipset_part_id) REFERENCES chipset_part (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_chipset_part ADD CONSTRAINT fk_1d67f578bc1433b9 FOREIGN KEY (chipset_id) REFERENCES chipset (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_expansion_chip DROP CONSTRAINT FK_A5DDC5C4BC1433B9');
        $this->addSql('ALTER TABLE chipset_expansion_chip DROP CONSTRAINT FK_A5DDC5C479A869A1');
        $this->addSql('DROP TABLE chipset_expansion_chip');
        $this->addSql('ALTER TABLE chipset_part ADD description VARCHAR(8192) DEFAULT NULL');
        $this->addSql('ALTER TABLE chipset_part ADD rank INT NOT NULL');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240817174047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chipset_chip (chipset_id INT NOT NULL, chip_id INT NOT NULL, PRIMARY KEY(chipset_id, chip_id))');
        $this->addSql('CREATE INDEX IDX_499362DEBC1433B9 ON chipset_chip (chipset_id)');
        $this->addSql('CREATE INDEX IDX_499362DEA588ADB3 ON chipset_chip (chip_id)');
        $this->addSql('CREATE TABLE motherboard_chip (motherboard_id INT NOT NULL, chip_id INT NOT NULL, PRIMARY KEY(motherboard_id, chip_id))');
        $this->addSql('CREATE INDEX IDX_E8BF4A5C6511E8A3 ON motherboard_chip (motherboard_id)');
        $this->addSql('CREATE INDEX IDX_E8BF4A5CA588ADB3 ON motherboard_chip (chip_id)');
        $this->addSql('ALTER TABLE chipset_chip ADD CONSTRAINT FK_499362DEBC1433B9 FOREIGN KEY (chipset_id) REFERENCES chipset (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_chip ADD CONSTRAINT FK_499362DEA588ADB3 FOREIGN KEY (chip_id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_chip ADD CONSTRAINT FK_E8BF4A5C6511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_chip ADD CONSTRAINT FK_E8BF4A5CA588ADB3 FOREIGN KEY (chip_id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_expansion_chip DROP CONSTRAINT fk_a5ddc5c479a869a1');
        $this->addSql('ALTER TABLE chipset_expansion_chip DROP CONSTRAINT fk_a5ddc5c4bc1433b9');
        $this->addSql('ALTER TABLE motherboard_expansion_chip DROP CONSTRAINT fk_310193806511e8a3');
        $this->addSql('ALTER TABLE motherboard_expansion_chip DROP CONSTRAINT fk_3101938079a869a1');
        $this->addSql('INSERT INTO chipset_chip (chipset_id, chip_id) (SELECT * FROM chipset_expansion_chip)');
        $this->addSql('INSERT INTO motherboard_chip (motherboard_id, chip_id) (SELECT * FROM motherboard_expansion_chip)');
        $this->addSql('DROP TABLE chipset_expansion_chip');
        $this->addSql('DROP TABLE motherboard_expansion_chip');
        $this->addSql('ALTER TABLE chip ADD description VARCHAR(8192) DEFAULT NULL');
        $this->addSql('UPDATE chip c SET description = ec.description FROM expansion_chip ec WHERE ec.id=c.id');
        $this->addSql('ALTER TABLE expansion_chip DROP description');
        $this->addSql('ALTER TABLE large_file_expansion_chip DROP CONSTRAINT fk_9b42aed379a869a1');
        $this->addSql('DROP INDEX idx_9b42aed379a869a1');
        $this->addSql('ALTER TABLE large_file_expansion_chip RENAME COLUMN expansion_chip_id TO chip_id');
        $this->addSql('ALTER TABLE large_file_expansion_chip ADD CONSTRAINT FK_9B42AED3A588ADB3 FOREIGN KEY (chip_id) REFERENCES chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9B42AED3A588ADB3 ON large_file_expansion_chip (chip_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE chipset_expansion_chip (chipset_id INT NOT NULL, expansion_chip_id INT NOT NULL, PRIMARY KEY(chipset_id, expansion_chip_id))');
        $this->addSql('CREATE INDEX idx_a5ddc5c4bc1433b9 ON chipset_expansion_chip (chipset_id)');
        $this->addSql('CREATE INDEX idx_a5ddc5c479a869a1 ON chipset_expansion_chip (expansion_chip_id)');
        $this->addSql('CREATE TABLE motherboard_expansion_chip (motherboard_id INT NOT NULL, expansion_chip_id INT NOT NULL, PRIMARY KEY(motherboard_id, expansion_chip_id))');
        $this->addSql('CREATE INDEX idx_3101938079a869a1 ON motherboard_expansion_chip (expansion_chip_id)');
        $this->addSql('CREATE INDEX idx_310193806511e8a3 ON motherboard_expansion_chip (motherboard_id)');
        $this->addSql('ALTER TABLE chipset_expansion_chip ADD CONSTRAINT fk_a5ddc5c479a869a1 FOREIGN KEY (expansion_chip_id) REFERENCES expansion_chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_expansion_chip ADD CONSTRAINT fk_a5ddc5c4bc1433b9 FOREIGN KEY (chipset_id) REFERENCES chipset (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_expansion_chip ADD CONSTRAINT fk_310193806511e8a3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_expansion_chip ADD CONSTRAINT fk_3101938079a869a1 FOREIGN KEY (expansion_chip_id) REFERENCES expansion_chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_chip DROP CONSTRAINT FK_499362DEBC1433B9');
        $this->addSql('ALTER TABLE chipset_chip DROP CONSTRAINT FK_499362DEA588ADB3');
        $this->addSql('ALTER TABLE motherboard_chip DROP CONSTRAINT FK_E8BF4A5C6511E8A3');
        $this->addSql('ALTER TABLE motherboard_chip DROP CONSTRAINT FK_E8BF4A5CA588ADB3');
        $this->addSql('DROP TABLE chipset_chip');
        $this->addSql('DROP TABLE motherboard_chip');
        $this->addSql('ALTER TABLE chip DROP description');
        $this->addSql('ALTER TABLE large_file_expansion_chip DROP CONSTRAINT FK_9B42AED3A588ADB3');
        $this->addSql('DROP INDEX IDX_9B42AED3A588ADB3');
        $this->addSql('ALTER TABLE large_file_expansion_chip RENAME COLUMN chip_id TO expansion_chip_id');
        $this->addSql('ALTER TABLE large_file_expansion_chip ADD CONSTRAINT fk_9b42aed379a869a1 FOREIGN KEY (expansion_chip_id) REFERENCES expansion_chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_9b42aed379a869a1 ON large_file_expansion_chip (expansion_chip_id)');
        $this->addSql('ALTER TABLE expansion_chip ADD description VARCHAR(8192) DEFAULT NULL');
    }
}

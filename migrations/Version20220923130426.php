<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923130426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE motherboard_expansion_chip (motherboard_id INT NOT NULL, expansion_chip_id INT NOT NULL, PRIMARY KEY(motherboard_id, expansion_chip_id))');
        $this->addSql('CREATE INDEX IDX_310193806511E8A3 ON motherboard_expansion_chip (motherboard_id)');
        $this->addSql('CREATE INDEX IDX_3101938079A869A1 ON motherboard_expansion_chip (expansion_chip_id)');
        $this->addSql('ALTER TABLE motherboard_expansion_chip ADD CONSTRAINT FK_310193806511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_expansion_chip ADD CONSTRAINT FK_3101938079A869A1 FOREIGN KEY (expansion_chip_id) REFERENCES expansion_chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        //$this->addSql('DROP TABLE audio_chipset');
        //$this->addSql('ALTER TABLE motherboard DROP audio_chipset_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        //$this->addSql('CREATE TABLE audio_chipset (id INT NOT NULL, manufacturer_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, chip_name VARCHAR(255) DEFAULT NULL, type_id INT DEFAULT 1 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_1a6a4483c54c8c93 ON audio_chipset (type_id)');
        $this->addSql('CREATE INDEX idx_1a6a4483a23b42d ON audio_chipset (manufacturer_id)');
        $this->addSql('ALTER TABLE motherboard_expansion_chip DROP CONSTRAINT FK_310193806511E8A3');
        $this->addSql('ALTER TABLE motherboard_expansion_chip DROP CONSTRAINT FK_3101938079A869A1');
        $this->addSql('DROP TABLE motherboard_expansion_chip');
        //$this->addSql('ALTER TABLE motherboard ADD audio_chipset_id INT DEFAULT NULL');
    }
}

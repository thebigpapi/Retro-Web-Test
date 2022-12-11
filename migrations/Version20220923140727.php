<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923140727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO motherboard_expansion_chip (motherboard_id, expansion_chip_id) SELECT id, audio_chipset_id AS audio_chipset_id FROM motherboard WHERE audio_chipset_id IS NOT NULL;');
        $this->addSql('INSERT INTO motherboard_expansion_chip (motherboard_id, expansion_chip_id) SELECT id, video_chipset_id+226 AS video_chipset_id FROM motherboard WHERE video_chipset_id IS NOT NULL;');
        $this->addSql('ALTER TABLE motherboard DROP CONSTRAINT fk_7f7a0f2b3cb32b0f');
        $this->addSql('DROP SEQUENCE video_chipset_id_seq CASCADE');
        $this->addSql('ALTER TABLE video_chipset DROP CONSTRAINT fk_c030a4f2a23b42d');
        $this->addSql('DROP TABLE audio_chipset');
        $this->addSql('DROP TABLE video_chipset');
        $this->addSql('DROP INDEX idx_7f7a0f2b3cb32b0f');
        $this->addSql('ALTER TABLE motherboard DROP video_chipset_id');
        $this->addSql('ALTER TABLE motherboard DROP audio_chipset_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE video_chipset_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE audio_chipset (id INT NOT NULL, manufacturer_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, chip_name VARCHAR(255) DEFAULT NULL, type_id INT DEFAULT 1 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_1a6a4483c54c8c93 ON audio_chipset (type_id)');
        $this->addSql('CREATE INDEX idx_1a6a4483a23b42d ON audio_chipset (manufacturer_id)');
        $this->addSql('CREATE TABLE video_chipset (id INT NOT NULL, manufacturer_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, chip_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_c030a4f2a23b42d ON video_chipset (manufacturer_id)');
        $this->addSql('ALTER TABLE video_chipset ADD CONSTRAINT fk_c030a4f2a23b42d FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard ADD video_chipset_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE motherboard ADD audio_chipset_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE motherboard ADD CONSTRAINT fk_7f7a0f2b3cb32b0f FOREIGN KEY (video_chipset_id) REFERENCES video_chipset (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7f7a0f2b3cb32b0f ON motherboard (video_chipset_id)');
    }
}

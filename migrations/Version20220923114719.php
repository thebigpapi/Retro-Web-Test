<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923114719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE motherboard DROP CONSTRAINT fk_7f7a0f2bbc4062b4');
        $this->addSql('DROP SEQUENCE audio_chipset_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE large_file_audio_chipset_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE expansion_chip_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE large_file_expansion_chip_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_chip (id INT NOT NULL, manufacturer_id INT DEFAULT NULL, type_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, chip_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BA8E6BEA23B42D ON expansion_chip (manufacturer_id)');
        $this->addSql('CREATE INDEX IDX_3BA8E6BEC54C8C93 ON expansion_chip (type_id)');
        $this->addSql('CREATE TABLE large_file_expansion_chip (id INT NOT NULL, large_file_id INT NOT NULL, expansion_chip_id INT NOT NULL, is_recommended BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9B42AED329EA72E8 ON large_file_expansion_chip (large_file_id)');
        $this->addSql('CREATE INDEX IDX_9B42AED379A869A1 ON large_file_expansion_chip (expansion_chip_id)');
        $this->addSql('ALTER TABLE expansion_chip ADD CONSTRAINT FK_3BA8E6BEA23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_chip ADD CONSTRAINT FK_3BA8E6BEC54C8C93 FOREIGN KEY (type_id) REFERENCES expansion_chip_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_expansion_chip ADD CONSTRAINT FK_9B42AED329EA72E8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_expansion_chip ADD CONSTRAINT FK_9B42AED379A869A1 FOREIGN KEY (expansion_chip_id) REFERENCES expansion_chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE audio_chipset DROP CONSTRAINT fk_1a6a4483a23b42d');
        $this->addSql('ALTER TABLE audio_chipset DROP CONSTRAINT fk_1a6a4483c54c8c93');
        $this->addSql('ALTER TABLE large_file_audio_chipset DROP CONSTRAINT fk_fac0516329ea72e8');
        $this->addSql('ALTER TABLE large_file_audio_chipset DROP CONSTRAINT fk_fac05163bc4062b4');
        //$this->addSql('DROP TABLE audio_chipset');
        $this->addSql('DROP TABLE large_file_audio_chipset');
        $this->addSql('DROP INDEX idx_7f7a0f2bbc4062b4');
        //$this->addSql('ALTER TABLE motherboard RENAME COLUMN audio_chipset_id TO expansion_chip_id');
        //$this->addSql('ALTER TABLE motherboard ADD CONSTRAINT FK_7F7A0F2B79A869A1 FOREIGN KEY (expansion_chip_id) REFERENCES expansion_chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        //$this->addSql('CREATE INDEX IDX_7F7A0F2B79A869A1 ON motherboard (expansion_chip_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE motherboard DROP CONSTRAINT FK_7F7A0F2B79A869A1');
        $this->addSql('DROP SEQUENCE expansion_chip_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE large_file_expansion_chip_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE audio_chipset_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE large_file_audio_chipset_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE audio_chipset (id INT NOT NULL, manufacturer_id INT DEFAULT NULL, type_id INT DEFAULT 1 NOT NULL, name VARCHAR(255) DEFAULT NULL, chip_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_1a6a4483c54c8c93 ON audio_chipset (type_id)');
        $this->addSql('CREATE INDEX idx_1a6a4483a23b42d ON audio_chipset (manufacturer_id)');
        $this->addSql('CREATE TABLE large_file_audio_chipset (id INT NOT NULL, large_file_id INT NOT NULL, audio_chipset_id INT NOT NULL, is_recommended BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_fac05163bc4062b4 ON large_file_audio_chipset (audio_chipset_id)');
        $this->addSql('CREATE INDEX idx_fac0516329ea72e8 ON large_file_audio_chipset (large_file_id)');
        $this->addSql('ALTER TABLE audio_chipset ADD CONSTRAINT fk_1a6a4483a23b42d FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE audio_chipset ADD CONSTRAINT fk_1a6a4483c54c8c93 FOREIGN KEY (type_id) REFERENCES expansion_chip_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_audio_chipset ADD CONSTRAINT fk_fac0516329ea72e8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_audio_chipset ADD CONSTRAINT fk_fac05163bc4062b4 FOREIGN KEY (audio_chipset_id) REFERENCES audio_chipset (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_chip DROP CONSTRAINT FK_3BA8E6BEA23B42D');
        $this->addSql('ALTER TABLE expansion_chip DROP CONSTRAINT FK_3BA8E6BEC54C8C93');
        $this->addSql('ALTER TABLE large_file_expansion_chip DROP CONSTRAINT FK_9B42AED329EA72E8');
        $this->addSql('ALTER TABLE large_file_expansion_chip DROP CONSTRAINT FK_9B42AED379A869A1');
        $this->addSql('DROP TABLE expansion_chip');
        $this->addSql('DROP TABLE large_file_expansion_chip');
        $this->addSql('DROP INDEX IDX_7F7A0F2B79A869A1');
        $this->addSql('ALTER TABLE motherboard RENAME COLUMN expansion_chip_id TO audio_chipset_id');
        $this->addSql('ALTER TABLE motherboard ADD CONSTRAINT fk_7f7a0f2bbc4062b4 FOREIGN KEY (audio_chipset_id) REFERENCES audio_chipset (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7f7a0f2bbc4062b4 ON motherboard (audio_chipset_id)');
    }
}

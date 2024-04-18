<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230925221519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE audio_file_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE storage_device_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE storage_device_documentation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE storage_device_image_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE storage_device_interface_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE storage_device_size_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE audio_file (id INT NOT NULL, storage_device_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C32E2A4C7CBFD8DB ON audio_file (storage_device_id)');
        $this->addSql('CREATE TABLE cd_drive (id INT NOT NULL, cd_read_speed SMALLINT DEFAULT NULL, cd_write_speed SMALLINT DEFAULT NULL, dvd_read_speed SMALLINT DEFAULT NULL, dvd_write_speed SMALLINT DEFAULT NULL, tray_type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE floppy_drive (id INT NOT NULL, density VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE hard_drive (id INT NOT NULL, capacity INT NOT NULL, cylinders SMALLINT DEFAULT NULL, heads SMALLINT DEFAULT NULL, sectors SMALLINT DEFAULT NULL, spindle_speed SMALLINT DEFAULT NULL, platters SMALLINT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE storage_device (id INT NOT NULL, manufacturer_id INT DEFAULT NULL, interface_id INT DEFAULT NULL, physical_size_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, part_number VARCHAR(255) NOT NULL, description VARCHAR(4096) DEFAULT NULL, dtype VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_322C428FA23B42D ON storage_device (manufacturer_id)');
        $this->addSql('CREATE INDEX IDX_322C428FAB0BE982 ON storage_device (interface_id)');
        $this->addSql('CREATE INDEX IDX_322C428F5D35000A ON storage_device (physical_size_id)');
        $this->addSql('CREATE TABLE storage_device_known_issue (storage_device_id INT NOT NULL, known_issue_id INT NOT NULL, PRIMARY KEY(storage_device_id, known_issue_id))');
        $this->addSql('CREATE INDEX IDX_97A1F25D7CBFD8DB ON storage_device_known_issue (storage_device_id)');
        $this->addSql('CREATE INDEX IDX_97A1F25D32096F65 ON storage_device_known_issue (known_issue_id)');
        $this->addSql('CREATE TABLE storage_device_documentation (id INT NOT NULL, storage_device_id INT DEFAULT NULL, language_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, link_name VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B98EF2457CBFD8DB ON storage_device_documentation (storage_device_id)');
        $this->addSql('CREATE INDEX IDX_B98EF24582F1BAF4 ON storage_device_documentation (language_id)');
        $this->addSql('CREATE TABLE storage_device_image (id INT NOT NULL, storage_device_id INT NOT NULL, creditor_id INT DEFAULT NULL, file_name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4FDB649F7CBFD8DB ON storage_device_image (storage_device_id)');
        $this->addSql('CREATE INDEX IDX_4FDB649FDF91AC92 ON storage_device_image (creditor_id)');
        $this->addSql('CREATE TABLE storage_device_interface (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE storage_device_size (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE audio_file ADD CONSTRAINT FK_C32E2A4C7CBFD8DB FOREIGN KEY (storage_device_id) REFERENCES storage_device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cd_drive ADD CONSTRAINT FK_1758A877BF396750 FOREIGN KEY (id) REFERENCES storage_device (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE floppy_drive ADD CONSTRAINT FK_B07C2B88BF396750 FOREIGN KEY (id) REFERENCES storage_device (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hard_drive ADD CONSTRAINT FK_A8C9FFBEBF396750 FOREIGN KEY (id) REFERENCES storage_device (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device ADD CONSTRAINT FK_322C428FA23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device ADD CONSTRAINT FK_322C428FAB0BE982 FOREIGN KEY (interface_id) REFERENCES storage_device_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device ADD CONSTRAINT FK_322C428F5D35000A FOREIGN KEY (physical_size_id) REFERENCES storage_device_size (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device_known_issue ADD CONSTRAINT FK_97A1F25D7CBFD8DB FOREIGN KEY (storage_device_id) REFERENCES storage_device (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device_known_issue ADD CONSTRAINT FK_97A1F25D32096F65 FOREIGN KEY (known_issue_id) REFERENCES known_issue (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device_documentation ADD CONSTRAINT FK_B98EF2457CBFD8DB FOREIGN KEY (storage_device_id) REFERENCES storage_device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device_documentation ADD CONSTRAINT FK_B98EF24582F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device_image ADD CONSTRAINT FK_4FDB649F7CBFD8DB FOREIGN KEY (storage_device_id) REFERENCES storage_device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device_image ADD CONSTRAINT FK_4FDB649FDF91AC92 FOREIGN KEY (creditor_id) REFERENCES creditor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE SEQUENCE storage_device_alias_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE storage_device_alias (id INT NOT NULL, manufacturer_id INT DEFAULT NULL, storage_device_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, part_number VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6B8A0B54A23B42D ON storage_device_alias (manufacturer_id)');
        $this->addSql('CREATE INDEX IDX_6B8A0B547CBFD8DB ON storage_device_alias (storage_device_id)');
        $this->addSql('ALTER TABLE storage_device_alias ADD CONSTRAINT FK_6B8A0B54A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device_alias ADD CONSTRAINT FK_6B8A0B547CBFD8DB FOREIGN KEY (storage_device_id) REFERENCES storage_device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE storage_device ADD last_edited TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE audio_file_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE storage_device_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE storage_device_documentation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE storage_device_image_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE storage_device_interface_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE storage_device_size_id_seq CASCADE');
        $this->addSql('ALTER TABLE audio_file DROP CONSTRAINT FK_C32E2A4C7CBFD8DB');
        $this->addSql('ALTER TABLE cd_drive DROP CONSTRAINT FK_1758A877BF396750');
        $this->addSql('ALTER TABLE floppy_drive DROP CONSTRAINT FK_B07C2B88BF396750');
        $this->addSql('ALTER TABLE hard_drive DROP CONSTRAINT FK_A8C9FFBEBF396750');
        $this->addSql('ALTER TABLE storage_device DROP CONSTRAINT FK_322C428FA23B42D');
        $this->addSql('ALTER TABLE storage_device DROP CONSTRAINT FK_322C428FAB0BE982');
        $this->addSql('ALTER TABLE storage_device DROP CONSTRAINT FK_322C428F5D35000A');
        $this->addSql('ALTER TABLE storage_device_known_issue DROP CONSTRAINT FK_97A1F25D7CBFD8DB');
        $this->addSql('ALTER TABLE storage_device_known_issue DROP CONSTRAINT FK_97A1F25D32096F65');
        $this->addSql('ALTER TABLE storage_device_documentation DROP CONSTRAINT FK_B98EF2457CBFD8DB');
        $this->addSql('ALTER TABLE storage_device_documentation DROP CONSTRAINT FK_B98EF24582F1BAF4');
        $this->addSql('ALTER TABLE storage_device_image DROP CONSTRAINT FK_4FDB649F7CBFD8DB');
        $this->addSql('ALTER TABLE storage_device_image DROP CONSTRAINT FK_4FDB649FDF91AC92');
        $this->addSql('DROP TABLE audio_file');
        $this->addSql('DROP TABLE cd_drive');
        $this->addSql('DROP TABLE floppy_drive');
        $this->addSql('DROP TABLE hard_drive');
        $this->addSql('DROP TABLE storage_device');
        $this->addSql('DROP TABLE storage_device_known_issue');
        $this->addSql('DROP TABLE storage_device_documentation');
        $this->addSql('DROP TABLE storage_device_image');
        $this->addSql('DROP TABLE storage_device_interface');
        $this->addSql('DROP TABLE storage_device_size');
    }
}

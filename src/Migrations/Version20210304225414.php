<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304225414 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE chipset_part_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE chip_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE instruction_set_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE chip (id INT NOT NULL, manufacturer_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, chip_no VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AA29BCBBA23B42D ON chip (manufacturer_id)');
        $this->addSql('CREATE TABLE instruction_set (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE processing_unit (id INT NOT NULL, speed_id INT DEFAULT NULL, platform_id INT DEFAULT NULL, instruction_set_id INT DEFAULT NULL, fsb_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1F72DC5E8F3A8393 ON processing_unit (speed_id)');
        $this->addSql('CREATE INDEX IDX_1F72DC5EFFE6496F ON processing_unit (platform_id)');
        $this->addSql('CREATE INDEX IDX_1F72DC5E929CC919 ON processing_unit (instruction_set_id)');
        $this->addSql('CREATE INDEX IDX_1F72DC5ED932F451 ON processing_unit (fsb_id)');
        $this->addSql('ALTER TABLE chip ADD CONSTRAINT FK_AA29BCBBA23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit ADD CONSTRAINT FK_1F72DC5E8F3A8393 FOREIGN KEY (speed_id) REFERENCES cpu_speed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit ADD CONSTRAINT FK_1F72DC5EFFE6496F FOREIGN KEY (platform_id) REFERENCES processor_platform_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit ADD CONSTRAINT FK_1F72DC5E929CC919 FOREIGN KEY (instruction_set_id) REFERENCES instruction_set (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit ADD CONSTRAINT FK_1F72DC5ED932F451 FOREIGN KEY (fsb_id) REFERENCES cpu_speed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit ADD CONSTRAINT FK_1F72DC5EBF396750 FOREIGN KEY (id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_part DROP CONSTRAINT fk_aab5aea3a23b42d');
        $this->addSql('DROP INDEX idx_aab5aea3a23b42d');
        $this->addSql('ALTER TABLE chipset_part DROP manufacturer_id');
        $this->addSql('ALTER TABLE chipset_part DROP name');
        $this->addSql('ALTER TABLE chipset_part DROP chip_no');
        $this->addSql('ALTER TABLE chipset_part ADD CONSTRAINT FK_AAB5AEA3BF396750 FOREIGN KEY (id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chipset_part DROP CONSTRAINT FK_AAB5AEA3BF396750');
        $this->addSql('ALTER TABLE processing_unit DROP CONSTRAINT FK_1F72DC5EBF396750');
        $this->addSql('ALTER TABLE processing_unit DROP CONSTRAINT FK_1F72DC5E929CC919');
        $this->addSql('DROP SEQUENCE chip_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE instruction_set_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE chipset_part_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE chip');
        $this->addSql('DROP TABLE instruction_set');
        $this->addSql('DROP TABLE processing_unit');
        $this->addSql('ALTER TABLE chipset_part ADD manufacturer_id INT NOT NULL');
        $this->addSql('ALTER TABLE chipset_part ADD name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE chipset_part ADD chip_no VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE chipset_part ADD CONSTRAINT fk_aab5aea3a23b42d FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_aab5aea3a23b42d ON chipset_part (manufacturer_id)');
    }
}

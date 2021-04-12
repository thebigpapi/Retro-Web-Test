<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210411141322 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE license_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE creditor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE known_issue_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE processor_voltage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE motherboard_image_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE manufacturer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cpu_socket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE chip_alias_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE chip_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE manual_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE processor_platform_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE language_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE chipset_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE chip_image_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE motherboard_image_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cache_method_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE motherboard_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE max_ram_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cache_size_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cpu_speed_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE motherboard_alias_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE video_chipset_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE motherboard_bios_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE form_factor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE instruction_set_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE io_port_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cache_ratio_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE audio_chipset_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE expansion_slot_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE dram_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE processor_voltage (id INT NOT NULL, processor_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D614E2FE37BAC19A ON processor_voltage (processor_id)');
        $this->addSql('ALTER TABLE processor_voltage ADD CONSTRAINT FK_D614E2FE37BAC19A FOREIGN KEY (processor_id) REFERENCES processor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor DROP voltage');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE license_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE creditor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE known_issue_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE processor_voltage_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE motherboard_image_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE manufacturer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cpu_socket_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE chip_alias_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE chip_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE manual_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE processor_platform_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE language_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE chipset_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE chip_image_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE motherboard_image_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cache_method_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE motherboard_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE max_ram_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cache_size_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE cpu_speed_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE motherboard_alias_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE video_chipset_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE motherboard_bios_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE form_factor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE instruction_set_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE io_port_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cache_ratio_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE audio_chipset_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE expansion_slot_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE dram_type_id_seq CASCADE');
        $this->addSql('DROP TABLE processor_voltage');
        $this->addSql('ALTER TABLE processor ADD voltage DOUBLE PRECISION NOT NULL');
    }
}

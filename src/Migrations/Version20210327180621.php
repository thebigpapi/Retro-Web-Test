<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210327180621 extends AbstractMigration
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
        $this->addSql('ALTER TABLE cpu_socket ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE cpu_socket ALTER name DROP NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE license_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE creditor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE known_issue_id_seq CASCADE');
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
        $this->addSql('ALTER TABLE cpu_socket DROP type');
        $this->addSql('ALTER TABLE cpu_socket ALTER name SET NOT NULL');
    }
}

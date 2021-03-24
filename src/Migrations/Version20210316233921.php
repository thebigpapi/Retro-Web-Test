<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316233921 extends AbstractMigration
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
        $this->addSql('CREATE TABLE cpu_socket (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cpu_socket_processor_platform_type (cpu_socket_id INT NOT NULL, processor_platform_type_id INT NOT NULL, PRIMARY KEY(cpu_socket_id, processor_platform_type_id))');
        $this->addSql('CREATE INDEX IDX_2CD1411C6B6A65A0 ON cpu_socket_processor_platform_type (cpu_socket_id)');
        $this->addSql('CREATE INDEX IDX_2CD1411CA90B5CBC ON cpu_socket_processor_platform_type (processor_platform_type_id)');
        $this->addSql('CREATE TABLE processor_platform_type_motherboard (processor_platform_type_id INT NOT NULL, motherboard_id INT NOT NULL, PRIMARY KEY(processor_platform_type_id, motherboard_id))');
        $this->addSql('CREATE INDEX IDX_91AC6702A90B5CBC ON processor_platform_type_motherboard (processor_platform_type_id)');
        $this->addSql('CREATE INDEX IDX_91AC67026511E8A3 ON processor_platform_type_motherboard (motherboard_id)');
        $this->addSql('CREATE TABLE motherboard_processor_platform_type (motherboard_id INT NOT NULL, processor_platform_type_id INT NOT NULL, PRIMARY KEY(motherboard_id, processor_platform_type_id))');
        $this->addSql('CREATE INDEX IDX_417BADED6511E8A3 ON motherboard_processor_platform_type (motherboard_id)');
        $this->addSql('CREATE INDEX IDX_417BADEDA90B5CBC ON motherboard_processor_platform_type (processor_platform_type_id)');
        $this->addSql('CREATE TABLE motherboard_cpu_socket (motherboard_id INT NOT NULL, cpu_socket_id INT NOT NULL, PRIMARY KEY(motherboard_id, cpu_socket_id))');
        $this->addSql('CREATE INDEX IDX_8BF3B2736511E8A3 ON motherboard_cpu_socket (motherboard_id)');
        $this->addSql('CREATE INDEX IDX_8BF3B2736B6A65A0 ON motherboard_cpu_socket (cpu_socket_id)');
        $this->addSql('CREATE TABLE expansion_slot (id INT NOT NULL, name VARCHAR(255) NOT NULL, hidden_search BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE cpu_socket_processor_platform_type ADD CONSTRAINT FK_2CD1411C6B6A65A0 FOREIGN KEY (cpu_socket_id) REFERENCES cpu_socket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cpu_socket_processor_platform_type ADD CONSTRAINT FK_2CD1411CA90B5CBC FOREIGN KEY (processor_platform_type_id) REFERENCES processor_platform_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor_platform_type_motherboard ADD CONSTRAINT FK_91AC6702A90B5CBC FOREIGN KEY (processor_platform_type_id) REFERENCES processor_platform_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor_platform_type_motherboard ADD CONSTRAINT FK_91AC67026511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_processor_platform_type ADD CONSTRAINT FK_417BADED6511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_processor_platform_type ADD CONSTRAINT FK_417BADEDA90B5CBC FOREIGN KEY (processor_platform_type_id) REFERENCES processor_platform_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_cpu_socket ADD CONSTRAINT FK_8BF3B2736511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_cpu_socket ADD CONSTRAINT FK_8BF3B2736B6A65A0 FOREIGN KEY (cpu_socket_id) REFERENCES cpu_socket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_expansion_slot ADD CONSTRAINT FK_37260F5C85C5D58E FOREIGN KEY (expansion_slot_id) REFERENCES expansion_slot (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard DROP CONSTRAINT fk_7f7a0f2ba90b5cbc');
        $this->addSql('DROP INDEX idx_7f7a0f2ba90b5cbc');
        $this->addSql('ALTER TABLE motherboard DROP processor_platform_type_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cpu_socket_processor_platform_type DROP CONSTRAINT FK_2CD1411C6B6A65A0');
        $this->addSql('ALTER TABLE motherboard_cpu_socket DROP CONSTRAINT FK_8BF3B2736B6A65A0');
        $this->addSql('ALTER TABLE motherboard_expansion_slot DROP CONSTRAINT FK_37260F5C85C5D58E');
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
        $this->addSql('DROP TABLE cpu_socket');
        $this->addSql('DROP TABLE cpu_socket_processor_platform_type');
        $this->addSql('DROP TABLE processor_platform_type_motherboard');
        $this->addSql('DROP TABLE motherboard_processor_platform_type');
        $this->addSql('DROP TABLE motherboard_cpu_socket');
        $this->addSql('DROP TABLE expansion_slot');
        $this->addSql('ALTER TABLE motherboard ADD processor_platform_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE motherboard ADD CONSTRAINT fk_7f7a0f2ba90b5cbc FOREIGN KEY (processor_platform_type_id) REFERENCES processor_platform_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_7f7a0f2ba90b5cbc ON motherboard (processor_platform_type_id)');
    }
}

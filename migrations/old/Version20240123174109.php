<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123174109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE expansion_slot_interface_signal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_slot_interface_signal (id INT NOT NULL, interface_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C7BEEEE0AB0BE982 ON expansion_slot_interface_signal (interface_id)');
        $this->addSql('CREATE TABLE expansion_slot_interface_signal_expansion_slot_signal (expansion_slot_interface_signal_id INT NOT NULL, expansion_slot_signal_id INT NOT NULL, PRIMARY KEY(expansion_slot_interface_signal_id, expansion_slot_signal_id))');
        $this->addSql('CREATE INDEX IDX_C62B4528238755BE ON expansion_slot_interface_signal_expansion_slot_signal (expansion_slot_interface_signal_id)');
        $this->addSql('CREATE INDEX IDX_C62B45286E6229F4 ON expansion_slot_interface_signal_expansion_slot_signal (expansion_slot_signal_id)');
        $this->addSql('CREATE TABLE expansion_slot_interface_signal_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_13516580d79cb21d5b543445289ed3af_idx ON expansion_slot_interface_signal_audit (type)');
        $this->addSql('CREATE INDEX object_id_13516580d79cb21d5b543445289ed3af_idx ON expansion_slot_interface_signal_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_13516580d79cb21d5b543445289ed3af_idx ON expansion_slot_interface_signal_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_13516580d79cb21d5b543445289ed3af_idx ON expansion_slot_interface_signal_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_13516580d79cb21d5b543445289ed3af_idx ON expansion_slot_interface_signal_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_13516580d79cb21d5b543445289ed3af_idx ON expansion_slot_interface_signal_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN expansion_slot_interface_signal_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE io_port_interface_signal_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_5682bf927c8552a5d82c9ab13721f0ad_idx ON io_port_interface_signal_audit (type)');
        $this->addSql('CREATE INDEX object_id_5682bf927c8552a5d82c9ab13721f0ad_idx ON io_port_interface_signal_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_5682bf927c8552a5d82c9ab13721f0ad_idx ON io_port_interface_signal_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_5682bf927c8552a5d82c9ab13721f0ad_idx ON io_port_interface_signal_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_5682bf927c8552a5d82c9ab13721f0ad_idx ON io_port_interface_signal_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_5682bf927c8552a5d82c9ab13721f0ad_idx ON io_port_interface_signal_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN io_port_interface_signal_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE expansion_slot_interface_signal ADD CONSTRAINT FK_C7BEEEE0AB0BE982 FOREIGN KEY (interface_id) REFERENCES expansion_slot_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_slot_interface_signal_expansion_slot_signal ADD CONSTRAINT FK_C62B4528238755BE FOREIGN KEY (expansion_slot_interface_signal_id) REFERENCES expansion_slot_interface_signal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_slot_interface_signal_expansion_slot_signal ADD CONSTRAINT FK_C62B45286E6229F4 FOREIGN KEY (expansion_slot_signal_id) REFERENCES expansion_slot_signal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chip_image ADD sort SMALLINT NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE entity_documentation ADD io_port_interface_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_documentation ADD io_port_signal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_documentation ADD expansion_slot_signal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_documentation ADD expansion_slot_interface_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_documentation ADD CONSTRAINT FK_527E0537E20DBC82 FOREIGN KEY (io_port_interface_id) REFERENCES io_port_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_documentation ADD CONSTRAINT FK_527E05378DB8E228 FOREIGN KEY (io_port_signal_id) REFERENCES io_port_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_documentation ADD CONSTRAINT FK_527E05376E6229F4 FOREIGN KEY (expansion_slot_signal_id) REFERENCES expansion_slot_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_documentation ADD CONSTRAINT FK_527E05372896457A FOREIGN KEY (expansion_slot_interface_id) REFERENCES expansion_slot_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_527E0537E20DBC82 ON entity_documentation (io_port_interface_id)');
        $this->addSql('CREATE INDEX IDX_527E05378DB8E228 ON entity_documentation (io_port_signal_id)');
        $this->addSql('CREATE INDEX IDX_527E05376E6229F4 ON entity_documentation (expansion_slot_signal_id)');
        $this->addSql('CREATE INDEX IDX_527E05372896457A ON entity_documentation (expansion_slot_interface_id)');
        $this->addSql('ALTER TABLE entity_image ADD io_port_interface_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_image ADD io_port_signal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_image ADD expansion_slot_signal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_image ADD expansion_slot_interface_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE entity_image ADD CONSTRAINT FK_69C931A6E20DBC82 FOREIGN KEY (io_port_interface_id) REFERENCES io_port_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_image ADD CONSTRAINT FK_69C931A68DB8E228 FOREIGN KEY (io_port_signal_id) REFERENCES io_port_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_image ADD CONSTRAINT FK_69C931A66E6229F4 FOREIGN KEY (expansion_slot_signal_id) REFERENCES expansion_slot_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE entity_image ADD CONSTRAINT FK_69C931A62896457A FOREIGN KEY (expansion_slot_interface_id) REFERENCES expansion_slot_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_69C931A6E20DBC82 ON entity_image (io_port_interface_id)');
        $this->addSql('CREATE INDEX IDX_69C931A68DB8E228 ON entity_image (io_port_signal_id)');
        $this->addSql('CREATE INDEX IDX_69C931A66E6229F4 ON entity_image (expansion_slot_signal_id)');
        $this->addSql('CREATE INDEX IDX_69C931A62896457A ON entity_image (expansion_slot_interface_id)');
        $this->addSql('ALTER TABLE expansion_card ADD expansion_slot_interface_signal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_card ADD fccid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_card ADD CONSTRAINT FK_8795C2D6238755BE FOREIGN KEY (expansion_slot_interface_signal_id) REFERENCES expansion_slot_interface_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8795C2D6238755BE ON expansion_card (expansion_slot_interface_signal_id)');
        $this->addSql('ALTER TABLE expansion_slot_interface ADD description VARCHAR(4096) DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_slot_signal ADD description VARCHAR(4096) DEFAULT NULL');
        $this->addSql('ALTER TABLE io_port_interface ADD description VARCHAR(4096) DEFAULT NULL');
        $this->addSql('ALTER TABLE io_port_signal ADD description VARCHAR(4096) DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_slot_interface_signal ADD name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_slot_interface_signal ADD description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE chip ADD sort SMALLINT NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE chip ALTER sort DROP DEFAULT');
        $this->addSql('ALTER TABLE chip_image ALTER sort DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expansion_card DROP CONSTRAINT FK_8795C2D6238755BE');
        $this->addSql('DROP SEQUENCE expansion_slot_interface_signal_id_seq CASCADE');
        $this->addSql('ALTER TABLE expansion_slot_interface_signal DROP CONSTRAINT FK_C7BEEEE0AB0BE982');
        $this->addSql('ALTER TABLE expansion_slot_interface_signal_expansion_slot_signal DROP CONSTRAINT FK_C62B4528238755BE');
        $this->addSql('ALTER TABLE expansion_slot_interface_signal_expansion_slot_signal DROP CONSTRAINT FK_C62B45286E6229F4');
        $this->addSql('DROP TABLE expansion_slot_interface_signal');
        $this->addSql('DROP TABLE expansion_slot_interface_signal_expansion_slot_signal');
        $this->addSql('DROP TABLE expansion_slot_interface_signal_audit');
        $this->addSql('DROP TABLE io_port_interface_signal_audit');
        $this->addSql('ALTER TABLE expansion_slot_interface DROP description');
        $this->addSql('ALTER TABLE entity_documentation DROP CONSTRAINT FK_527E0537E20DBC82');
        $this->addSql('ALTER TABLE entity_documentation DROP CONSTRAINT FK_527E05378DB8E228');
        $this->addSql('ALTER TABLE entity_documentation DROP CONSTRAINT FK_527E05376E6229F4');
        $this->addSql('ALTER TABLE entity_documentation DROP CONSTRAINT FK_527E05372896457A');
        $this->addSql('DROP INDEX IDX_527E0537E20DBC82');
        $this->addSql('DROP INDEX IDX_527E05378DB8E228');
        $this->addSql('DROP INDEX IDX_527E05376E6229F4');
        $this->addSql('DROP INDEX IDX_527E05372896457A');
        $this->addSql('ALTER TABLE entity_documentation DROP io_port_interface_id');
        $this->addSql('ALTER TABLE entity_documentation DROP io_port_signal_id');
        $this->addSql('ALTER TABLE entity_documentation DROP expansion_slot_signal_id');
        $this->addSql('ALTER TABLE entity_documentation DROP expansion_slot_interface_id');
        $this->addSql('ALTER TABLE entity_image DROP CONSTRAINT FK_69C931A6E20DBC82');
        $this->addSql('ALTER TABLE entity_image DROP CONSTRAINT FK_69C931A68DB8E228');
        $this->addSql('ALTER TABLE entity_image DROP CONSTRAINT FK_69C931A66E6229F4');
        $this->addSql('ALTER TABLE entity_image DROP CONSTRAINT FK_69C931A62896457A');
        $this->addSql('DROP INDEX IDX_69C931A6E20DBC82');
        $this->addSql('DROP INDEX IDX_69C931A68DB8E228');
        $this->addSql('DROP INDEX IDX_69C931A66E6229F4');
        $this->addSql('DROP INDEX IDX_69C931A62896457A');
        $this->addSql('ALTER TABLE entity_image DROP io_port_interface_id');
        $this->addSql('ALTER TABLE entity_image DROP io_port_signal_id');
        $this->addSql('ALTER TABLE entity_image DROP expansion_slot_signal_id');
        $this->addSql('ALTER TABLE entity_image DROP expansion_slot_interface_id');
        $this->addSql('ALTER TABLE chip_image DROP sort');
        $this->addSql('ALTER TABLE io_port_signal DROP description');
        $this->addSql('ALTER TABLE expansion_slot_signal DROP description');
        $this->addSql('DROP INDEX IDX_8795C2D6238755BE');
        $this->addSql('ALTER TABLE expansion_card DROP expansion_slot_interface_signal_id');
        $this->addSql('ALTER TABLE expansion_card DROP fccid');
        $this->addSql('ALTER TABLE io_port_interface DROP description');
    }
}

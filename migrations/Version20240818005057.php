<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240818005057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE processor_voltage_audit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE processor_voltage_id_seq CASCADE');
        $this->addSql('CREATE TABLE chip_cpu_socket (chip_id INT NOT NULL, cpu_socket_id INT NOT NULL, PRIMARY KEY(chip_id, cpu_socket_id))');
        $this->addSql('CREATE INDEX IDX_320776D6A588ADB3 ON chip_cpu_socket (chip_id)');
        $this->addSql('CREATE INDEX IDX_320776D66B6A65A0 ON chip_cpu_socket (cpu_socket_id)');
        $this->addSql('ALTER TABLE chip_cpu_socket ADD CONSTRAINT FK_320776D6A588ADB3 FOREIGN KEY (chip_id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chip_cpu_socket ADD CONSTRAINT FK_320776D66B6A65A0 FOREIGN KEY (cpu_socket_id) REFERENCES cpu_socket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit_cpu_socket DROP CONSTRAINT fk_db937a2b6b6a65a0');
        $this->addSql('ALTER TABLE processing_unit_cpu_socket DROP CONSTRAINT fk_db937a2b93e55c96');
        $this->addSql('ALTER TABLE processor_voltage DROP CONSTRAINT fk_d614e2fe37bac19a');
        $this->addSql('INSERT INTO chip_cpu_socket (chip_id, cpu_socket_id) (SELECT * FROM processing_unit_cpu_socket)');
        $this->addSql('DROP TABLE processing_unit_cpu_socket');
        $this->addSql('DROP TABLE processor_voltage');
        $this->addSql('DROP TABLE processor_voltage_audit');
        $this->addSql('ALTER TABLE chip ADD family_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chip ADD tdp DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('UPDATE chip c set family_id=pu.platform_id, tdp=p.tdp FROM processing_unit pu JOIN processor p ON pu.id=p.id WHERE c.id=pu.id');
        $this->addSql('ALTER TABLE chip ADD process_node INT DEFAULT NULL');
        $this->addSql('UPDATE chip c set process_node=ppt.process_node FROM processor_platform_type ppt WHERE c.family_id=ppt.id');
        $this->addSql('ALTER TABLE chip ADD CONSTRAINT FK_AA29BCBBC35E566A FOREIGN KEY (family_id) REFERENCES processor_platform_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_AA29BCBBC35E566A ON chip (family_id)');
        $this->addSql('ALTER TABLE processing_unit DROP CONSTRAINT fk_1f72dc5e8f3a8393');
        $this->addSql('ALTER TABLE processing_unit DROP CONSTRAINT fk_1f72dc5ed932f451');
        $this->addSql('ALTER TABLE processing_unit DROP CONSTRAINT fk_1f72dc5effe6496f');
        $this->addSql('DROP INDEX idx_1f72dc5effe6496f');
        $this->addSql('DROP INDEX idx_1f72dc5ed932f451');
        $this->addSql('DROP INDEX idx_1f72dc5e8f3a8393');
        $this->addSql('ALTER TABLE processing_unit DROP speed_id');
        $this->addSql('ALTER TABLE processing_unit DROP platform_id');
        $this->addSql('ALTER TABLE processing_unit DROP fsb_id');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT fk_29c0465059c24159');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT fk_29c04650e17e263c');
        $this->addSql('DROP INDEX idx_29c04650e17e263c');
        $this->addSql('DROP INDEX idx_29c0465059c24159');
        $this->addSql('ALTER TABLE processor DROP l2_id');
        $this->addSql('ALTER TABLE processor DROP l3_id');
        $this->addSql('ALTER TABLE processor DROP core');
        $this->addSql('ALTER TABLE processor DROP tdp');
        $this->addSql('ALTER TABLE processor DROP process_node');
        $this->addSql('ALTER TABLE processor DROP cores');
        $this->addSql('ALTER TABLE processor DROP threads');
        $this->addSql('ALTER TABLE processor DROP l2shared');
        $this->addSql('ALTER TABLE processor DROP l3shared');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE processor_voltage_audit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE processor_voltage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE processing_unit_cpu_socket (processing_unit_id INT NOT NULL, cpu_socket_id INT NOT NULL, PRIMARY KEY(processing_unit_id, cpu_socket_id))');
        $this->addSql('CREATE INDEX idx_db937a2b93e55c96 ON processing_unit_cpu_socket (processing_unit_id)');
        $this->addSql('CREATE INDEX idx_db937a2b6b6a65a0 ON processing_unit_cpu_socket (cpu_socket_id)');
        $this->addSql('CREATE TABLE processor_voltage (id INT NOT NULL, processor_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_d614e2fe37bac19a ON processor_voltage (processor_id)');
        $this->addSql('CREATE TABLE processor_voltage_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_e9f5f3e8617d2db8c5e26a498ea2d3d4_idx ON processor_voltage_audit (type)');
        $this->addSql('CREATE INDEX transaction_hash_e9f5f3e8617d2db8c5e26a498ea2d3d4_idx ON processor_voltage_audit (transaction_hash)');
        $this->addSql('CREATE INDEX object_id_e9f5f3e8617d2db8c5e26a498ea2d3d4_idx ON processor_voltage_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_e9f5f3e8617d2db8c5e26a498ea2d3d4_idx ON processor_voltage_audit (discriminator)');
        $this->addSql('CREATE INDEX created_at_e9f5f3e8617d2db8c5e26a498ea2d3d4_idx ON processor_voltage_audit (created_at)');
        $this->addSql('CREATE INDEX blame_id_e9f5f3e8617d2db8c5e26a498ea2d3d4_idx ON processor_voltage_audit (blame_id)');
        $this->addSql('COMMENT ON COLUMN processor_voltage_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE processing_unit_cpu_socket ADD CONSTRAINT fk_db937a2b6b6a65a0 FOREIGN KEY (cpu_socket_id) REFERENCES cpu_socket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit_cpu_socket ADD CONSTRAINT fk_db937a2b93e55c96 FOREIGN KEY (processing_unit_id) REFERENCES processing_unit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor_voltage ADD CONSTRAINT fk_d614e2fe37bac19a FOREIGN KEY (processor_id) REFERENCES processor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chip_cpu_socket DROP CONSTRAINT FK_320776D6A588ADB3');
        $this->addSql('ALTER TABLE chip_cpu_socket DROP CONSTRAINT FK_320776D66B6A65A0');
        $this->addSql('DROP TABLE chip_cpu_socket');
        $this->addSql('ALTER TABLE chip DROP CONSTRAINT FK_AA29BCBBC35E566A');
        $this->addSql('DROP INDEX IDX_AA29BCBBC35E566A');
        $this->addSql('ALTER TABLE chip DROP family_id');
        $this->addSql('ALTER TABLE chip DROP tdp');
        $this->addSql('ALTER TABLE chip DROP process_node');
        $this->addSql('ALTER TABLE processing_unit ADD speed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processing_unit ADD platform_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processing_unit ADD fsb_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processing_unit ADD CONSTRAINT fk_1f72dc5e8f3a8393 FOREIGN KEY (speed_id) REFERENCES cpu_speed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit ADD CONSTRAINT fk_1f72dc5ed932f451 FOREIGN KEY (fsb_id) REFERENCES cpu_speed (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit ADD CONSTRAINT fk_1f72dc5effe6496f FOREIGN KEY (platform_id) REFERENCES processor_platform_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1f72dc5effe6496f ON processing_unit (platform_id)');
        $this->addSql('CREATE INDEX idx_1f72dc5ed932f451 ON processing_unit (fsb_id)');
        $this->addSql('CREATE INDEX idx_1f72dc5e8f3a8393 ON processing_unit (speed_id)');
        $this->addSql('ALTER TABLE processor ADD l2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD l3_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD core VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD tdp DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD process_node INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD cores SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD threads SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD l2shared BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD l3shared BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT fk_29c0465059c24159 FOREIGN KEY (l2_id) REFERENCES cache_size (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT fk_29c04650e17e263c FOREIGN KEY (l3_id) REFERENCES cache_size (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_29c04650e17e263c ON processor (l3_id)');
        $this->addSql('CREATE INDEX idx_29c0465059c24159 ON processor (l2_id)');
    }
}

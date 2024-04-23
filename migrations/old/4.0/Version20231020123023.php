<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231020123023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE processor_platform_type_instruction_set (processor_platform_type_id INT NOT NULL, instruction_set_id INT NOT NULL, PRIMARY KEY(processor_platform_type_id, instruction_set_id))');
        $this->addSql('CREATE INDEX IDX_3FEAEF83A90B5CBC ON processor_platform_type_instruction_set (processor_platform_type_id)');
        $this->addSql('CREATE INDEX IDX_3FEAEF83929CC919 ON processor_platform_type_instruction_set (instruction_set_id)');
        $this->addSql('ALTER TABLE processor_platform_type_instruction_set ADD CONSTRAINT FK_3FEAEF83A90B5CBC FOREIGN KEY (processor_platform_type_id) REFERENCES processor_platform_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor_platform_type_instruction_set ADD CONSTRAINT FK_3FEAEF83929CC919 FOREIGN KEY (instruction_set_id) REFERENCES instruction_set (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit_instruction_set DROP CONSTRAINT fk_bc595800929cc919');
        $this->addSql('ALTER TABLE processing_unit_instruction_set DROP CONSTRAINT fk_bc59580093e55c96');
        $this->addSql('DROP TABLE processing_unit_instruction_set');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT fk_29c046501c944943');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT fk_29c046502d259658');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT fk_29c046504b77eeb7');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT fk_29c04650b2fcd8d2');
        $this->addSql('DROP INDEX idx_29c04650b2fcd8d2');
        $this->addSql('DROP INDEX idx_29c046504b77eeb7');
        $this->addSql('DROP INDEX idx_29c046502d259658');
        $this->addSql('DROP INDEX idx_29c046501c944943');
        $this->addSql('ALTER TABLE processor ADD l2shared BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD l3shared BOOLEAN DEFAULT NULL');
        $this->addSql("UPDATE processor SET l2shared=true");
        $this->addSql("UPDATE processor SET l3shared=true");
        $this->addSql('ALTER TABLE processor DROP l1_id');
        $this->addSql('ALTER TABLE processor DROP l1_cache_method_id');
        $this->addSql('ALTER TABLE processor DROP l2_cache_ratio_id');
        $this->addSql('ALTER TABLE processor DROP l3_cache_ratio_id');
        $this->addSql('ALTER TABLE processor_platform_type ADD l1data_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor_platform_type ADD l1code_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor_platform_type ADD process_node INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor_platform_type ADD l1code_ratio DOUBLE PRECISION NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE processor_platform_type ADD l1data_ratio DOUBLE PRECISION NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE processor_platform_type ADD has_imc BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE processor_platform_type ADD CONSTRAINT FK_30909C82BFA04BBF FOREIGN KEY (l1data_id) REFERENCES cache_size (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor_platform_type ADD CONSTRAINT FK_30909C82AF8F1494 FOREIGN KEY (l1code_id) REFERENCES cache_size (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_30909C82BFA04BBF ON processor_platform_type (l1data_id)');
        $this->addSql('CREATE INDEX IDX_30909C82AF8F1494 ON processor_platform_type (l1code_id)');
        $this->addSql('ALTER TABLE processor_platform_type ALTER l1code_ratio DROP DEFAULT');
        $this->addSql('ALTER TABLE processor_platform_type ALTER l1data_ratio DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE processing_unit_instruction_set (processing_unit_id INT NOT NULL, instruction_set_id INT NOT NULL, PRIMARY KEY(processing_unit_id, instruction_set_id))');
        $this->addSql('CREATE INDEX idx_bc59580093e55c96 ON processing_unit_instruction_set (processing_unit_id)');
        $this->addSql('CREATE INDEX idx_bc595800929cc919 ON processing_unit_instruction_set (instruction_set_id)');
        $this->addSql('ALTER TABLE processing_unit_instruction_set ADD CONSTRAINT fk_bc595800929cc919 FOREIGN KEY (instruction_set_id) REFERENCES instruction_set (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit_instruction_set ADD CONSTRAINT fk_bc59580093e55c96 FOREIGN KEY (processing_unit_id) REFERENCES processing_unit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor_platform_type_instruction_set DROP CONSTRAINT FK_3FEAEF83A90B5CBC');
        $this->addSql('ALTER TABLE processor_platform_type_instruction_set DROP CONSTRAINT FK_3FEAEF83929CC919');
        $this->addSql('DROP TABLE processor_platform_type_instruction_set');
        $this->addSql('ALTER TABLE processor ADD l1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD l1_cache_method_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD l2_cache_ratio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD l3_cache_ratio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor DROP l2shared');
        $this->addSql('ALTER TABLE processor DROP l3shared');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT fk_29c046501c944943 FOREIGN KEY (l3_cache_ratio_id) REFERENCES cache_ratio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT fk_29c046502d259658 FOREIGN KEY (l1_cache_method_id) REFERENCES cache_method (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT fk_29c046504b77eeb7 FOREIGN KEY (l1_id) REFERENCES cache_size (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT fk_29c04650b2fcd8d2 FOREIGN KEY (l2_cache_ratio_id) REFERENCES cache_ratio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_29c04650b2fcd8d2 ON processor (l2_cache_ratio_id)');
        $this->addSql('CREATE INDEX idx_29c046504b77eeb7 ON processor (l1_id)');
        $this->addSql('CREATE INDEX idx_29c046502d259658 ON processor (l1_cache_method_id)');
        $this->addSql('CREATE INDEX idx_29c046501c944943 ON processor (l3_cache_ratio_id)');
        $this->addSql('ALTER TABLE processor_platform_type DROP CONSTRAINT FK_30909C82BFA04BBF');
        $this->addSql('ALTER TABLE processor_platform_type DROP CONSTRAINT FK_30909C82AF8F1494');
        $this->addSql('DROP INDEX IDX_30909C82BFA04BBF');
        $this->addSql('DROP INDEX IDX_30909C82AF8F1494');
        $this->addSql('ALTER TABLE processor_platform_type DROP l1data_id');
        $this->addSql('ALTER TABLE processor_platform_type DROP l1code_id');
        $this->addSql('ALTER TABLE processor_platform_type DROP process_node');
        $this->addSql('ALTER TABLE processor_platform_type DROP l1code_ratio');
        $this->addSql('ALTER TABLE processor_platform_type DROP l1data_ratio');
        $this->addSql('ALTER TABLE processor_platform_type DROP has_imc');
    }
}

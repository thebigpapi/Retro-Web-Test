<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409161212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chipset_documentation DROP CONSTRAINT fk_6263703c82f1baf4');
        $this->addSql('ALTER TABLE expansion_card_documentation DROP CONSTRAINT fk_5722523b82f1baf4');
        $this->addSql('ALTER TABLE manual DROP CONSTRAINT fk_10dbbec482f1baf4');
        $this->addSql('ALTER TABLE storage_device_documentation DROP CONSTRAINT fk_b98ef24582f1baf4');
        $this->addSql('ALTER TABLE chip_documentation DROP CONSTRAINT fk_10fb0bc882f1baf4');
        $this->addSql('ALTER TABLE entity_documentation DROP CONSTRAINT fk_527e053782f1baf4');
        $this->addSql('DROP SEQUENCE language_id_seq CASCADE');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP INDEX idx_10fb0bc882f1baf4');
        $this->addSql('ALTER TABLE chip_documentation DROP language_id');
        $this->addSql('DROP INDEX idx_6263703c82f1baf4');
        $this->addSql('ALTER TABLE chipset_documentation DROP language_id');
        $this->addSql('DROP INDEX idx_527e053782f1baf4');
        $this->addSql('ALTER TABLE entity_documentation DROP language_id');
        $this->addSql('DROP INDEX idx_5722523b82f1baf4');
        $this->addSql('ALTER TABLE expansion_card_documentation DROP language_id');
        $this->addSql('DROP INDEX idx_10dbbec482f1baf4');
        $this->addSql('ALTER TABLE manual DROP language_id');
        $this->addSql('DROP INDEX idx_b98ef24582f1baf4');
        $this->addSql('ALTER TABLE storage_device_documentation DROP language_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE language_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE language (id INT NOT NULL, name VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, iso_code VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE chipset_documentation ADD language_id INT NOT NULL');
        $this->addSql('ALTER TABLE chipset_documentation ADD CONSTRAINT fk_6263703c82f1baf4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6263703c82f1baf4 ON chipset_documentation (language_id)');
        $this->addSql('ALTER TABLE expansion_card_documentation ADD language_id INT NOT NULL');
        $this->addSql('ALTER TABLE expansion_card_documentation ADD CONSTRAINT fk_5722523b82f1baf4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5722523b82f1baf4 ON expansion_card_documentation (language_id)');
        $this->addSql('ALTER TABLE manual ADD language_id INT NOT NULL');
        $this->addSql('ALTER TABLE manual ADD CONSTRAINT fk_10dbbec482f1baf4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_10dbbec482f1baf4 ON manual (language_id)');
        $this->addSql('ALTER TABLE storage_device_documentation ADD language_id INT NOT NULL');
        $this->addSql('ALTER TABLE storage_device_documentation ADD CONSTRAINT fk_b98ef24582f1baf4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b98ef24582f1baf4 ON storage_device_documentation (language_id)');
        $this->addSql('ALTER TABLE chip_documentation ADD language_id INT NOT NULL');
        $this->addSql('ALTER TABLE chip_documentation ADD CONSTRAINT fk_10fb0bc882f1baf4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_10fb0bc882f1baf4 ON chip_documentation (language_id)');
        $this->addSql('ALTER TABLE entity_documentation ADD language_id INT NOT NULL');
        $this->addSql('ALTER TABLE entity_documentation ADD CONSTRAINT fk_527e053782f1baf4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_527e053782f1baf4 ON entity_documentation (language_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516132025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('DROP TABLE import');
        $this->addSql('ALTER TABLE chipset ALTER description TYPE VARCHAR(8192)');
        $this->addSql('ALTER TABLE chipset_part ALTER description TYPE VARCHAR(8192)');
        /*$this->addSql('ALTER TABLE chipset_part ALTER rank DROP DEFAULT');
        $this->addSql('DROP INDEX "primary"');
        $this->addSql('ALTER TABLE motherboard_psuconnector ADD PRIMARY KEY (motherboard_id, psuconnector_id)');
        $this->addSql('ALTER INDEX idx_df1d9f996511e8a3 RENAME TO IDX_BD0DB1996511E8A3');
        $this->addSql('ALTER INDEX idx_df1d9f99d6871168 RENAME TO IDX_BD0DB199D6871168');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT FK_29C04650BF396750 FOREIGN KEY (id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor_voltage ADD CONSTRAINT FK_D614E2FE37BAC19A FOREIGN KEY (processor_id) REFERENCES processor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    */}

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        /*$this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE import (id INT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL)');
        $this->addSql('ALTER TABLE chipset ALTER description TYPE VARCHAR(4096)');
        $this->addSql('DROP INDEX psuconnector_motherboard_pkey');
        $this->addSql('ALTER TABLE motherboard_psuconnector ADD PRIMARY KEY (psuconnector_id, motherboard_id)');
        $this->addSql('ALTER INDEX idx_bd0db199d6871168 RENAME TO idx_df1d9f99d6871168');
        $this->addSql('ALTER INDEX idx_bd0db1996511e8a3 RENAME TO idx_df1d9f996511e8a3');
        $this->addSql('ALTER TABLE processor_voltage DROP CONSTRAINT FK_D614E2FE37BAC19A');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT FK_29C04650BF396750');
        $this->addSql('ALTER TABLE chipset_part ALTER description TYPE VARCHAR(4096)');
        $this->addSql('ALTER TABLE chipset_part ALTER rank SET DEFAULT 1');*/
    }
}

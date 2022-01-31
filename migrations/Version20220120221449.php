<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120221449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE chipset_documentation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE chipset_documentation (id INT NOT NULL, chipset_id INT DEFAULT NULL, language_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, link_name VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6263703CBC1433B9 ON chipset_documentation (chipset_id)');
        $this->addSql('CREATE INDEX IDX_6263703C82F1BAF4 ON chipset_documentation (language_id)');
        $this->addSql('ALTER TABLE chipset_documentation ADD CONSTRAINT FK_6263703CBC1433B9 FOREIGN KEY (chipset_id) REFERENCES chipset (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_documentation ADD CONSTRAINT FK_6263703C82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        //$this->addSql('ALTER INDEX idx_df1d9f996511e8a3 RENAME TO IDX_BD0DB1996511E8A3');
        //$this->addSql('ALTER INDEX idx_df1d9f99d6871168 RENAME TO IDX_BD0DB199D6871168');
        //$this->addSql('ALTER TABLE processor ADD CONSTRAINT FK_29C04650BF396750 FOREIGN KEY (id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        //$this->addSql('ALTER TABLE processor_voltage ADD CONSTRAINT FK_D614E2FE37BAC19A FOREIGN KEY (processor_id) REFERENCES processor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE chipset_documentation_id_seq CASCADE');
        $this->addSql('DROP TABLE chipset_documentation');
        //$this->addSql('ALTER TABLE processor DROP CONSTRAINT FK_29C04650BF396750');
        //$this->addSql('ALTER TABLE processor_voltage DROP CONSTRAINT FK_D614E2FE37BAC19A');
        //$this->addSql('ALTER INDEX idx_bd0db1996511e8a3 RENAME TO idx_df1d9f996511e8a3');
        //$this->addSql('ALTER INDEX idx_bd0db199d6871168 RENAME TO idx_df1d9f99d6871168');
    }
}

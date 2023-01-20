<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120120023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE chipset_alias_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE chipset_alias (id INT NOT NULL, chipset_id INT NOT NULL, manufacturer_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, part_number VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DC57449DBC1433B9 ON chipset_alias (chipset_id)');
        $this->addSql('CREATE INDEX IDX_DC57449DA23B42D ON chipset_alias (manufacturer_id)');
        $this->addSql('ALTER TABLE chipset_alias ADD CONSTRAINT FK_DC57449DBC1433B9 FOREIGN KEY (chipset_id) REFERENCES chipset (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_alias ADD CONSTRAINT FK_DC57449DA23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE chipset_alias_id_seq CASCADE');
        $this->addSql('ALTER TABLE chipset_alias DROP CONSTRAINT FK_DC57449DBC1433B9');
        $this->addSql('ALTER TABLE chipset_alias DROP CONSTRAINT FK_DC57449DA23B42D');
        $this->addSql('DROP TABLE chipset_alias');
    }
}

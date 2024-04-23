<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923091751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE expansion_chip_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_chip_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO expansion_chip_type (id, name) VALUES (1, \'Audio\')');
        $this->addSql('ALTER TABLE audio_chipset ADD type_id INT NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE audio_chipset ADD CONSTRAINT FK_1A6A4483C54C8C93 FOREIGN KEY (type_id) REFERENCES expansion_chip_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1A6A4483C54C8C93 ON audio_chipset (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE audio_chipset DROP CONSTRAINT FK_1A6A4483C54C8C93');
        $this->addSql('DROP SEQUENCE expansion_chip_type_id_seq CASCADE');
        $this->addSql('DROP TABLE expansion_chip_type');
        $this->addSql('DROP INDEX IDX_1A6A4483C54C8C93');
        $this->addSql('ALTER TABLE audio_chipset DROP type_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923122000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // very important migration, merges audio and video chips to the new table
        $this->addSql('DELETE FROM expansion_chip');
        $this->addSql('DELETE FROM expansion_chip_type');
        $this->addSql('INSERT INTO expansion_chip_type (id, name) VALUES (1, \'Audio\'), (2, \'Video\')');
        $this->addSql('INSERT INTO expansion_chip (id, manufacturer_id, type_id, name, chip_name) SELECT id, manufacturer_id, type_id, name, chip_name FROM audio_chipset');
        $this->addSql('INSERT INTO expansion_chip (id, manufacturer_id, type_id, name, chip_name) SELECT id+226 AS id, manufacturer_id, 2, name, chip_name FROM video_chipset');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}

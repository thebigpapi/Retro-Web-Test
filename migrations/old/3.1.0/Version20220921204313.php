<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921204313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE large_file_audio_chipset_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE large_file_audio_chipset (id INT NOT NULL, large_file_id INT NOT NULL, audio_chipset_id INT NOT NULL, is_recommended BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FAC0516329EA72E8 ON large_file_audio_chipset (large_file_id)');
        $this->addSql('CREATE INDEX IDX_FAC05163BC4062B4 ON large_file_audio_chipset (audio_chipset_id)');
        $this->addSql('ALTER TABLE large_file_audio_chipset ADD CONSTRAINT FK_FAC0516329EA72E8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_audio_chipset ADD CONSTRAINT FK_FAC05163BC4062B4 FOREIGN KEY (audio_chipset_id) REFERENCES audio_chipset (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE large_file_audio_chipset_id_seq CASCADE');
        $this->addSql('ALTER TABLE large_file_audio_chipset DROP CONSTRAINT FK_FAC0516329EA72E8');
        $this->addSql('ALTER TABLE large_file_audio_chipset DROP CONSTRAINT FK_FAC05163BC4062B4');
        $this->addSql('DROP TABLE large_file_audio_chipset');
    }
}

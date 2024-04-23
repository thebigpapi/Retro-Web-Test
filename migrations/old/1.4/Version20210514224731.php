<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210514224731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chipset_large_file (chipset_id INT NOT NULL, large_file_id INT NOT NULL, PRIMARY KEY(chipset_id, large_file_id))');
        $this->addSql('CREATE INDEX IDX_3B1B4DC0BC1433B9 ON chipset_large_file (chipset_id)');
        $this->addSql('CREATE INDEX IDX_3B1B4DC029EA72E8 ON chipset_large_file (large_file_id)');
        $this->addSql('CREATE TABLE motherboard_large_file (motherboard_id INT NOT NULL, large_file_id INT NOT NULL, PRIMARY KEY(motherboard_id, large_file_id))');
        $this->addSql('CREATE INDEX IDX_AB8CBB076511E8A3 ON motherboard_large_file (motherboard_id)');
        $this->addSql('CREATE INDEX IDX_AB8CBB0729EA72E8 ON motherboard_large_file (large_file_id)');
        $this->addSql('ALTER TABLE chipset_large_file ADD CONSTRAINT FK_3B1B4DC0BC1433B9 FOREIGN KEY (chipset_id) REFERENCES chipset (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_large_file ADD CONSTRAINT FK_3B1B4DC029EA72E8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_large_file ADD CONSTRAINT FK_AB8CBB076511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_large_file ADD CONSTRAINT FK_AB8CBB0729EA72E8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE chipset_large_file');
        $this->addSql('DROP TABLE motherboard_large_file');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617010144 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE chipset_chipset_part (chipset_id INT NOT NULL, chipset_part_id INT NOT NULL, PRIMARY KEY(chipset_id, chipset_part_id))');
        $this->addSql('CREATE INDEX IDX_1D67F578BC1433B9 ON chipset_chipset_part (chipset_id)');
        $this->addSql('CREATE INDEX IDX_1D67F57836F0F0C7 ON chipset_chipset_part (chipset_part_id)');
        $this->addSql('ALTER TABLE chipset_chipset_part ADD CONSTRAINT FK_1D67F578BC1433B9 FOREIGN KEY (chipset_id) REFERENCES chipset (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_chipset_part ADD CONSTRAINT FK_1D67F57836F0F0C7 FOREIGN KEY (chipset_part_id) REFERENCES chipset_part (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE chipset_chipset_part');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914133907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chipset ALTER release_date DROP DEFAULT');
        $this->addSql('ALTER TABLE chipset ALTER release_date TYPE DATE USING release_date::date');
        $this->addSql('ALTER TABLE chipset ALTER date_precision DROP DEFAULT');
        $this->addSql('ALTER TABLE expansion_slot DROP hidden_search');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expansion_slot ADD hidden_search BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE chipset ALTER release_date TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE chipset ALTER date_precision SET DEFAULT \'d\'');
    }
}

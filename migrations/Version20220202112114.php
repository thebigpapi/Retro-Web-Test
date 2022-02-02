<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220202112114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chipset_part ADD description VARCHAR(4096) DEFAULT NULL');
        $this->addSql('ALTER TABLE chipset_part ADD rank INT NOT NULL DEFAULT (1)');
    }

    public function down(Schema $schema): void
    {

    }
}

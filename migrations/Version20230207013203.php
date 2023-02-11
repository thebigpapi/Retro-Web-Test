<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230207013203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chipset ADD last_edited TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT \'2019-04-30 00:00:00\'');
        $this->addSql('ALTER TABLE large_file ADD last_edited TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT \'2019-04-30 00:00:00\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE large_file DROP last_edited');
        $this->addSql('ALTER TABLE chipset DROP last_edited');
    }
}

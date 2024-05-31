<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220606172723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('DROP TABLE import');
        $this->addSql('ALTER TABLE chipset ALTER description TYPE VARCHAR(8192)');
        $this->addSql('ALTER TABLE chipset_part ALTER description TYPE VARCHAR(8192)');
        //$this->addSql('ALTER TABLE known_issue ADD description VARCHAR(512) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        //$this->addSql('CREATE TABLE import (id INT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL)');
        $this->addSql('ALTER TABLE chipset_part ALTER description TYPE VARCHAR(4096)');
        $this->addSql('ALTER TABLE chipset ALTER description TYPE VARCHAR(4096)');
        $this->addSql('ALTER TABLE known_issue DROP description');
    }
}
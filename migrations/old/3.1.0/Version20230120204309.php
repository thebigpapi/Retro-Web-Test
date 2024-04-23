<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120204309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chip DROP pcidev');
        $this->addSql('ALTER TABLE manufacturer ADD pciven INT DEFAULT NULL');
        $this->addSql('ALTER TABLE manufacturer DROP idpci');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE manufacturer ADD idpci VARCHAR(4) DEFAULT NULL');
        $this->addSql('ALTER TABLE manufacturer DROP pciven');
        $this->addSql('ALTER TABLE chip ADD pciven VARCHAR(4) DEFAULT NULL');
    }
}

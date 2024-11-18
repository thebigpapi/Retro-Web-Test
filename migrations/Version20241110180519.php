<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241110180519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entity_image ADD sort SMALLINT NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE expansion_card_image ADD sort SMALLINT NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE motherboard_image ADD sort SMALLINT NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE storage_device_image ADD sort SMALLINT NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE entity_image ALTER sort DROP DEFAULT');
        $this->addSql('ALTER TABLE expansion_card_image ALTER sort DROP DEFAULT');
        $this->addSql('ALTER TABLE motherboard_image ALTER sort DROP DEFAULT');
        $this->addSql('ALTER TABLE storage_device_image ALTER sort DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expansion_card_image DROP sort');
        $this->addSql('ALTER TABLE entity_image DROP sort');
        $this->addSql('ALTER TABLE storage_device_image DROP sort');
        $this->addSql('ALTER TABLE motherboard_image DROP sort');
    }
}

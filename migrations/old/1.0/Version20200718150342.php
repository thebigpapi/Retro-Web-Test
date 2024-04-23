<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200718150342 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE motherboard_image ADD creditor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE motherboard_image ADD CONSTRAINT FK_FB11E572DF91AC92 FOREIGN KEY (creditor_id) REFERENCES creditor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FB11E572DF91AC92 ON motherboard_image (creditor_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE motherboard_image DROP CONSTRAINT FK_FB11E572DF91AC92');
        $this->addSql('DROP INDEX IDX_FB11E572DF91AC92');
        $this->addSql('ALTER TABLE motherboard_image DROP creditor_id');
    }
}

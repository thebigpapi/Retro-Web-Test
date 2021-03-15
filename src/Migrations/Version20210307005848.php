<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307005848 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE chip_image_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE chip_image (id INT NOT NULL, chip_id INT NOT NULL, creditor_id INT DEFAULT NULL, license_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E3EAD662A588ADB3 ON chip_image (chip_id)');
        $this->addSql('CREATE INDEX IDX_E3EAD662DF91AC92 ON chip_image (creditor_id)');
        $this->addSql('CREATE INDEX IDX_E3EAD662460F904B ON chip_image (license_id)');
        $this->addSql('ALTER TABLE chip_image ADD CONSTRAINT FK_E3EAD662A588ADB3 FOREIGN KEY (chip_id) REFERENCES chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chip_image ADD CONSTRAINT FK_E3EAD662DF91AC92 FOREIGN KEY (creditor_id) REFERENCES creditor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chip_image ADD CONSTRAINT FK_E3EAD662460F904B FOREIGN KEY (license_id) REFERENCES license (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE chip_image_id_seq CASCADE');
        $this->addSql('DROP TABLE chip_image');
    }
}

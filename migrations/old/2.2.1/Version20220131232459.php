<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131232459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE chip_documentation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE chip_documentation (id INT NOT NULL, chip_id INT DEFAULT NULL, language_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, link_name VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_10FB0BC8A588ADB3 ON chip_documentation (chip_id)');
        $this->addSql('CREATE INDEX IDX_10FB0BC882F1BAF4 ON chip_documentation (language_id)');
        $this->addSql('ALTER TABLE chip_documentation ADD CONSTRAINT FK_10FB0BC8A588ADB3 FOREIGN KEY (chip_id) REFERENCES chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chip_documentation ADD CONSTRAINT FK_10FB0BC882F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard DROP last_user');
    }

    public function down(Schema $schema): void
    {
    }
}

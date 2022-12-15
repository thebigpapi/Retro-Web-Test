<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221215191729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE misc_file_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE misc_file (id INT NOT NULL, motherboard_id INT DEFAULT NULL, file_name VARCHAR(255) NOT NULL, link_name VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C0F9CF996511E8A3 ON misc_file (motherboard_id)');
        $this->addSql('ALTER TABLE misc_file ADD CONSTRAINT FK_C0F9CF996511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE misc_file_id_seq CASCADE');
        $this->addSql('ALTER TABLE misc_file DROP CONSTRAINT FK_C0F9CF996511E8A3');
        $this->addSql('DROP TABLE misc_file');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511174837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE dump_quality_flag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE dump_quality_flag (id INT NOT NULL, name VARCHAR(255) NOT NULL, tag_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE language ADD original_name VARCHAR(255)');
        $this->addSql('ALTER TABLE language ADD iso_code VARCHAR(10)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE dump_quality_flag_id_seq CASCADE');
        $this->addSql('DROP TABLE dump_quality_flag');
        $this->addSql('ALTER TABLE language DROP original_name');
        $this->addSql('ALTER TABLE language DROP iso_code');
    }
}

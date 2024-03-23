<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218232644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE memory_connector_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE motherboard_memory_connector_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE memory_connector (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE motherboard_memory_connector (id INT NOT NULL, motherboard_id INT NOT NULL, memory_connector_id INT NOT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2983E4856511E8A3 ON motherboard_memory_connector (motherboard_id)');
        $this->addSql('CREATE INDEX IDX_2983E485A1AA202C ON motherboard_memory_connector (memory_connector_id)');
        $this->addSql('ALTER TABLE motherboard_memory_connector ADD CONSTRAINT FK_2983E4856511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_memory_connector ADD CONSTRAINT FK_2983E485A1AA202C FOREIGN KEY (memory_connector_id) REFERENCES memory_connector (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE memory_connector_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE motherboard_memory_connector_id_seq CASCADE');
        $this->addSql('ALTER TABLE motherboard_memory_connector DROP CONSTRAINT FK_2983E4856511E8A3');
        $this->addSql('ALTER TABLE motherboard_memory_connector DROP CONSTRAINT FK_2983E485A1AA202C');
        $this->addSql('DROP TABLE memory_connector');
        $this->addSql('DROP TABLE motherboard_memory_connector');
    }
}

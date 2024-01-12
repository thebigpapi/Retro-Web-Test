<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112201115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_card_io_port DROP CONSTRAINT fk_3a34a3b2a211d31');
        $this->addSql('DROP SEQUENCE io_port2_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE io_port_interface_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE io_port_interface (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE io_port2');
        $this->addSql('ALTER TABLE expansion_card_io_port ADD CONSTRAINT FK_3A34A3B2A211D31 FOREIGN KEY (io_port_id) REFERENCES io_port_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_card_io_port DROP CONSTRAINT FK_3A34A3B2A211D31');
        $this->addSql('DROP SEQUENCE io_port_interface_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE io_port2_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE io_port2 (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE io_port_interface');
        $this->addSql('ALTER TABLE expansion_card_io_port ADD CONSTRAINT fk_3a34a3b2a211d31 FOREIGN KEY (io_port_id) REFERENCES io_port2 (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}

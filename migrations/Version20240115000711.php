<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240115000711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_card_io_port ADD io_port_interface_signal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE expansion_card_io_port ADD CONSTRAINT FK_3A34A3BF9AD71B2 FOREIGN KEY (io_port_interface_signal_id) REFERENCES io_port_interface_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3A34A3BF9AD71B2 ON expansion_card_io_port (io_port_interface_signal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expansion_card_io_port DROP CONSTRAINT FK_3A34A3BF9AD71B2');
        $this->addSql('DROP INDEX IDX_3A34A3BF9AD71B2');
        $this->addSql('ALTER TABLE expansion_card_io_port DROP io_port_interface_signal_id');
    }
}

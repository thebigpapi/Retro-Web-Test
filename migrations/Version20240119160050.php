<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119160050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE io_port_interface_signal_io_port_signal (io_port_interface_signal_id INT NOT NULL, io_port_signal_id INT NOT NULL, PRIMARY KEY(io_port_interface_signal_id, io_port_signal_id))');
        $this->addSql('CREATE INDEX IDX_2BABD666F9AD71B2 ON io_port_interface_signal_io_port_signal (io_port_interface_signal_id)');
        $this->addSql('CREATE INDEX IDX_2BABD6668DB8E228 ON io_port_interface_signal_io_port_signal (io_port_signal_id)');
        $this->addSql('ALTER TABLE io_port_interface_signal_io_port_signal ADD CONSTRAINT FK_2BABD666F9AD71B2 FOREIGN KEY (io_port_interface_signal_id) REFERENCES io_port_interface_signal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE io_port_interface_signal_io_port_signal ADD CONSTRAINT FK_2BABD6668DB8E228 FOREIGN KEY (io_port_signal_id) REFERENCES io_port_signal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE io_port_interface_signal DROP CONSTRAINT fk_d77de088d0ce460b');
        $this->addSql('DROP INDEX idx_d77de088d0ce460b');
        $this->addSql('ALTER TABLE io_port_interface_signal DROP signal_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE io_port_interface_signal_io_port_signal DROP CONSTRAINT FK_2BABD666F9AD71B2');
        $this->addSql('ALTER TABLE io_port_interface_signal_io_port_signal DROP CONSTRAINT FK_2BABD6668DB8E228');
        $this->addSql('DROP TABLE io_port_interface_signal_io_port_signal');
        $this->addSql('ALTER TABLE io_port_interface_signal ADD signal_id INT NOT NULL');
        $this->addSql('ALTER TABLE io_port_interface_signal ADD CONSTRAINT fk_d77de088d0ce460b FOREIGN KEY (signal_id) REFERENCES io_port_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_d77de088d0ce460b ON io_port_interface_signal (signal_id)');
    }
}

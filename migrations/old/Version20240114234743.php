<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240114234743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE io_port_interface_signal DROP CONSTRAINT fk_d77de088b575f1dd');
        $this->addSql('ALTER TABLE io_port_interface_signal DROP CONSTRAINT fk_d77de088afc90acf');
        $this->addSql('DROP INDEX idx_d77de088afc90acf');
        $this->addSql('DROP INDEX idx_d77de088b575f1dd');
        $this->addSql('ALTER TABLE io_port_interface_signal ADD signal_id INT NOT NULL');
        $this->addSql('ALTER TABLE io_port_interface_signal ADD interface_id INT NOT NULL');
        $this->addSql('ALTER TABLE io_port_interface_signal DROP electrical_id');
        $this->addSql('ALTER TABLE io_port_interface_signal DROP mechanical_id');
        $this->addSql('ALTER TABLE io_port_interface_signal ADD CONSTRAINT FK_D77DE088D0CE460B FOREIGN KEY (signal_id) REFERENCES io_port_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE io_port_interface_signal ADD CONSTRAINT FK_D77DE088AB0BE982 FOREIGN KEY (interface_id) REFERENCES io_port_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D77DE088D0CE460B ON io_port_interface_signal (signal_id)');
        $this->addSql('CREATE INDEX IDX_D77DE088AB0BE982 ON io_port_interface_signal (interface_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE io_port_interface_signal DROP CONSTRAINT FK_D77DE088D0CE460B');
        $this->addSql('ALTER TABLE io_port_interface_signal DROP CONSTRAINT FK_D77DE088AB0BE982');
        $this->addSql('DROP INDEX IDX_D77DE088D0CE460B');
        $this->addSql('DROP INDEX IDX_D77DE088AB0BE982');
        $this->addSql('ALTER TABLE io_port_interface_signal ADD electrical_id INT NOT NULL');
        $this->addSql('ALTER TABLE io_port_interface_signal ADD mechanical_id INT NOT NULL');
        $this->addSql('ALTER TABLE io_port_interface_signal DROP signal_id');
        $this->addSql('ALTER TABLE io_port_interface_signal DROP interface_id');
        $this->addSql('ALTER TABLE io_port_interface_signal ADD CONSTRAINT fk_d77de088b575f1dd FOREIGN KEY (electrical_id) REFERENCES io_port_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE io_port_interface_signal ADD CONSTRAINT fk_d77de088afc90acf FOREIGN KEY (mechanical_id) REFERENCES io_port_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_d77de088afc90acf ON io_port_interface_signal (mechanical_id)');
        $this->addSql('CREATE INDEX idx_d77de088b575f1dd ON io_port_interface_signal (electrical_id)');
    }
}

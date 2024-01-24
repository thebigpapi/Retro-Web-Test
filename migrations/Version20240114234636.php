<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240114234636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE io_port_interface_signal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE io_port_interface_signal (id INT NOT NULL, electrical_id INT NOT NULL, mechanical_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D77DE088B575F1DD ON io_port_interface_signal (electrical_id)');
        $this->addSql('CREATE INDEX IDX_D77DE088AFC90ACF ON io_port_interface_signal (mechanical_id)');
        $this->addSql('ALTER TABLE io_port_interface_signal ADD CONSTRAINT FK_D77DE088B575F1DD FOREIGN KEY (electrical_id) REFERENCES io_port_signal (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE io_port_interface_signal ADD CONSTRAINT FK_D77DE088AFC90ACF FOREIGN KEY (mechanical_id) REFERENCES io_port_interface (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE io_port_interface_signal_id_seq CASCADE');
        $this->addSql('ALTER TABLE io_port_interface_signal DROP CONSTRAINT FK_D77DE088B575F1DD');
        $this->addSql('ALTER TABLE io_port_interface_signal DROP CONSTRAINT FK_D77DE088AFC90ACF');
        $this->addSql('DROP TABLE io_port_interface_signal');
    }
}

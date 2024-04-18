<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112203238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE io_port_type_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE io_port_signal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE expansion_card_io_port_io_port_signal (expansion_card_io_port_id INT NOT NULL, io_port_signal_id INT NOT NULL, PRIMARY KEY(expansion_card_io_port_id, io_port_signal_id))');
        $this->addSql('CREATE INDEX IDX_286AB091B369A9F ON expansion_card_io_port_io_port_signal (expansion_card_io_port_id)');
        $this->addSql('CREATE INDEX IDX_286AB0918DB8E228 ON expansion_card_io_port_io_port_signal (io_port_signal_id)');
        $this->addSql('CREATE TABLE io_port_signal (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE expansion_card_io_port_io_port_signal ADD CONSTRAINT FK_286AB091B369A9F FOREIGN KEY (expansion_card_io_port_id) REFERENCES expansion_card_io_port (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_io_port_io_port_signal ADD CONSTRAINT FK_286AB0918DB8E228 FOREIGN KEY (io_port_signal_id) REFERENCES io_port_signal (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_io_port_io_port_type DROP CONSTRAINT fk_a3ff080bb369a9f');
        $this->addSql('ALTER TABLE expansion_card_io_port_io_port_type DROP CONSTRAINT fk_a3ff080b7b9f1e01');
        $this->addSql('DROP TABLE io_port_type');
        $this->addSql('DROP TABLE expansion_card_io_port_io_port_type');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE io_port_signal_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE io_port_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE io_port_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE expansion_card_io_port_io_port_type (expansion_card_io_port_id INT NOT NULL, io_port_type_id INT NOT NULL, PRIMARY KEY(expansion_card_io_port_id, io_port_type_id))');
        $this->addSql('CREATE INDEX idx_a3ff080bb369a9f ON expansion_card_io_port_io_port_type (expansion_card_io_port_id)');
        $this->addSql('CREATE INDEX idx_a3ff080b7b9f1e01 ON expansion_card_io_port_io_port_type (io_port_type_id)');
        $this->addSql('ALTER TABLE expansion_card_io_port_io_port_type ADD CONSTRAINT fk_a3ff080bb369a9f FOREIGN KEY (expansion_card_io_port_id) REFERENCES expansion_card_io_port (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_io_port_io_port_type ADD CONSTRAINT fk_a3ff080b7b9f1e01 FOREIGN KEY (io_port_type_id) REFERENCES io_port_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_io_port_io_port_signal DROP CONSTRAINT FK_286AB091B369A9F');
        $this->addSql('ALTER TABLE expansion_card_io_port_io_port_signal DROP CONSTRAINT FK_286AB0918DB8E228');
        $this->addSql('DROP TABLE expansion_card_io_port_io_port_signal');
        $this->addSql('DROP TABLE io_port_signal');
    }
}

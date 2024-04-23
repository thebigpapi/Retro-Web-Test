<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230802200958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE motherboard_expansion_slot_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE motherboard_io_port_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('alter table motherboard_expansion_slot drop constraint motherboard_expansion_slot_pkey');
        $this->addSql('ALTER TABLE motherboard_expansion_slot ADD id INT');
        $this->addSql('update motherboard_expansion_slot set id=index
        from(select row_number() over() as index, motherboard_id, expansion_slot_id from motherboard_expansion_slot) as q
        where motherboard_expansion_slot.motherboard_id=q.motherboard_id and motherboard_expansion_slot.expansion_slot_id=q.expansion_slot_id;');
        $this->addSql('ALTER TABLE motherboard_expansion_slot ALTER COLUMN id SET NOT NULL');
        $this->addSql('ALTER TABLE motherboard_expansion_slot ADD PRIMARY KEY (id)');
        $this->addSql('alter table motherboard_io_port drop constraint motherboard_io_port_pkey');
        $this->addSql('ALTER TABLE motherboard_io_port ADD id INT');
        $this->addSql('update motherboard_io_port set id=index
        from(select row_number() over() as index, motherboard_id, io_port_id from motherboard_io_port) as q
        where motherboard_io_port.motherboard_id=q.motherboard_id and motherboard_io_port.io_port_id=q.io_port_id;');
        $this->addSql('ALTER TABLE motherboard_io_port ALTER COLUMN id SET NOT NULL');
        $this->addSql('ALTER TABLE motherboard_io_port ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE motherboard_expansion_slot_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE motherboard_io_port_id_seq CASCADE');
        $this->addSql('DROP INDEX motherboard_expansion_slot_pkey');
        $this->addSql('ALTER TABLE motherboard_expansion_slot DROP id');
        $this->addSql('ALTER TABLE motherboard_expansion_slot ADD PRIMARY KEY (motherboard_id, expansion_slot_id)');
        $this->addSql('DROP INDEX motherboard_io_port_pkey');
        $this->addSql('ALTER TABLE motherboard_io_port DROP id');
        $this->addSql('ALTER TABLE motherboard_io_port ADD PRIMARY KEY (motherboard_id, io_port_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230820190429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chipset ADD cached_name VARCHAR(255) NOT NULL DEFAULT \'\' ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE motherboard_expansion_slot_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE motherboard_io_port_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE motherboard_max_ram_id_seq CASCADE');
        $this->addSql('DROP INDEX motherboard_io_port_pkey');
        $this->addSql('ALTER TABLE motherboard_io_port DROP id');
        $this->addSql('ALTER TABLE motherboard_io_port ADD PRIMARY KEY (motherboard_id, io_port_id)');
        $this->addSql('DROP INDEX motherboard_max_ram_pkey');
        $this->addSql('ALTER TABLE motherboard_max_ram DROP id');
        $this->addSql('ALTER TABLE motherboard_max_ram ADD PRIMARY KEY (motherboard_id, max_ram_id)');
        $this->addSql('DROP INDEX motherboard_expansion_slot_pkey');
        $this->addSql('ALTER TABLE motherboard_expansion_slot DROP id');
        $this->addSql('ALTER TABLE motherboard_expansion_slot ADD PRIMARY KEY (motherboard_id, expansion_slot_id)');
        $this->addSql('ALTER TABLE chipset DROP cached_name');
    }
}

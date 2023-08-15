<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230802223751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE motherboard_max_ram_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('alter table motherboard_max_ram drop constraint motherboard_max_ram_pkey');
        $this->addSql('ALTER TABLE motherboard_max_ram ADD id INT');
        $this->addSql('update motherboard_max_ram set id=index
        from(select row_number() over() as index, motherboard_id, max_ram_id from motherboard_max_ram) as q
        where motherboard_max_ram.motherboard_id=q.motherboard_id and motherboard_max_ram.max_ram_id=q.max_ram_id;');
        $this->addSql('ALTER TABLE motherboard_max_ram ALTER COLUMN id SET NOT NULL');
        $this->addSql('ALTER TABLE motherboard_max_ram ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE motherboard_max_ram_id_seq CASCADE');
        $this->addSql('DROP INDEX motherboard_max_ram_pkey');
        $this->addSql('ALTER TABLE motherboard_max_ram DROP id');
        $this->addSql('ALTER TABLE motherboard_max_ram ADD PRIMARY KEY (motherboard_id, max_ram_id)');
    }
}

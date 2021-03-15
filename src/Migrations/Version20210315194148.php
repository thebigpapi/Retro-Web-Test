<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210315194148 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE motherboard_cpu_socket (motherboard_id INT NOT NULL, cpu_socket_id INT NOT NULL, PRIMARY KEY(motherboard_id, cpu_socket_id))');
        $this->addSql('CREATE INDEX IDX_8BF3B2736511E8A3 ON motherboard_cpu_socket (motherboard_id)');
        $this->addSql('CREATE INDEX IDX_8BF3B2736B6A65A0 ON motherboard_cpu_socket (cpu_socket_id)');
        $this->addSql('ALTER TABLE motherboard_cpu_socket ADD CONSTRAINT FK_8BF3B2736511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_cpu_socket ADD CONSTRAINT FK_8BF3B2736B6A65A0 FOREIGN KEY (cpu_socket_id) REFERENCES cpu_socket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE cpu_socket_motherboard');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE cpu_socket_motherboard (cpu_socket_id INT NOT NULL, motherboard_id INT NOT NULL, PRIMARY KEY(cpu_socket_id, motherboard_id))');
        $this->addSql('CREATE INDEX idx_303b66df6b6a65a0 ON cpu_socket_motherboard (cpu_socket_id)');
        $this->addSql('CREATE INDEX idx_303b66df6511e8a3 ON cpu_socket_motherboard (motherboard_id)');
        $this->addSql('ALTER TABLE cpu_socket_motherboard ADD CONSTRAINT fk_303b66df6b6a65a0 FOREIGN KEY (cpu_socket_id) REFERENCES cpu_socket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cpu_socket_motherboard ADD CONSTRAINT fk_303b66df6511e8a3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE motherboard_cpu_socket');
    }
}

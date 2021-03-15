<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210315173833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE cpu_socket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cpu_socket (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cpu_socket_processor_platform_type (cpu_socket_id INT NOT NULL, processor_platform_type_id INT NOT NULL, PRIMARY KEY(cpu_socket_id, processor_platform_type_id))');
        $this->addSql('CREATE INDEX IDX_2CD1411C6B6A65A0 ON cpu_socket_processor_platform_type (cpu_socket_id)');
        $this->addSql('CREATE INDEX IDX_2CD1411CA90B5CBC ON cpu_socket_processor_platform_type (processor_platform_type_id)');
        $this->addSql('CREATE TABLE cpu_socket_motherboard (cpu_socket_id INT NOT NULL, motherboard_id INT NOT NULL, PRIMARY KEY(cpu_socket_id, motherboard_id))');
        $this->addSql('CREATE INDEX IDX_303B66DF6B6A65A0 ON cpu_socket_motherboard (cpu_socket_id)');
        $this->addSql('CREATE INDEX IDX_303B66DF6511E8A3 ON cpu_socket_motherboard (motherboard_id)');
        $this->addSql('ALTER TABLE cpu_socket_processor_platform_type ADD CONSTRAINT FK_2CD1411C6B6A65A0 FOREIGN KEY (cpu_socket_id) REFERENCES cpu_socket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cpu_socket_processor_platform_type ADD CONSTRAINT FK_2CD1411CA90B5CBC FOREIGN KEY (processor_platform_type_id) REFERENCES processor_platform_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cpu_socket_motherboard ADD CONSTRAINT FK_303B66DF6B6A65A0 FOREIGN KEY (cpu_socket_id) REFERENCES cpu_socket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cpu_socket_motherboard ADD CONSTRAINT FK_303B66DF6511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cpu_socket_processor_platform_type DROP CONSTRAINT FK_2CD1411C6B6A65A0');
        $this->addSql('ALTER TABLE cpu_socket_motherboard DROP CONSTRAINT FK_303B66DF6B6A65A0');
        $this->addSql('DROP SEQUENCE cpu_socket_id_seq CASCADE');
        $this->addSql('DROP TABLE cpu_socket');
        $this->addSql('DROP TABLE cpu_socket_processor_platform_type');
        $this->addSql('DROP TABLE cpu_socket_motherboard');
    }
}

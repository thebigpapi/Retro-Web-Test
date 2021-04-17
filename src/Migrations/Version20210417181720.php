<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210417181720 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE processing_unit_cpu_socket (processing_unit_id INT NOT NULL, cpu_socket_id INT NOT NULL, PRIMARY KEY(processing_unit_id, cpu_socket_id))');
        $this->addSql('CREATE INDEX IDX_DB937A2B93E55C96 ON processing_unit_cpu_socket (processing_unit_id)');
        $this->addSql('CREATE INDEX IDX_DB937A2B6B6A65A0 ON processing_unit_cpu_socket (cpu_socket_id)');
        $this->addSql('ALTER TABLE processing_unit_cpu_socket ADD CONSTRAINT FK_DB937A2B93E55C96 FOREIGN KEY (processing_unit_id) REFERENCES processing_unit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit_cpu_socket ADD CONSTRAINT FK_DB937A2B6B6A65A0 FOREIGN KEY (cpu_socket_id) REFERENCES cpu_socket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE processing_unit_cpu_socket');
    }
}

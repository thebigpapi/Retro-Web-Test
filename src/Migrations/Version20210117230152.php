<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210117230152 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE motherboard_alias_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE motherboard_alias (id INT NOT NULL, motherboard_id INT NOT NULL, manufacturer_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DF408AB96511E8A3 ON motherboard_alias (motherboard_id)');
        $this->addSql('CREATE INDEX IDX_DF408AB9A23B42D ON motherboard_alias (manufacturer_id)');
        $this->addSql('ALTER TABLE motherboard_alias ADD CONSTRAINT FK_DF408AB96511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_alias ADD CONSTRAINT FK_DF408AB9A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_image ALTER file_name SET NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE motherboard_alias_id_seq CASCADE');
        $this->addSql('DROP TABLE motherboard_alias');
        $this->addSql('ALTER TABLE motherboard_image ALTER file_name DROP NOT NULL');
    }
}

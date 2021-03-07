<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307095718 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE instruction_set ADD compatible_with_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE instruction_set ADD CONSTRAINT FK_34C438493675E72 FOREIGN KEY (compatible_with_id) REFERENCES instruction_set (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_34C438493675E72 ON instruction_set (compatible_with_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE instruction_set DROP CONSTRAINT FK_34C438493675E72');
        $this->addSql('DROP INDEX IDX_34C438493675E72');
        $this->addSql('ALTER TABLE instruction_set DROP compatible_with_id');
    }
}

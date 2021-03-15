<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210306230405 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE coprocessor_id_seq CASCADE');
        $this->addSql('ALTER TABLE coprocessor DROP CONSTRAINT fk_4d944cd6a23b42d');
        $this->addSql('ALTER TABLE coprocessor DROP CONSTRAINT fk_4d944cd6a90b5cbc');
        $this->addSql('DROP INDEX idx_4d944cd6a23b42d');
        $this->addSql('DROP INDEX idx_4d944cd6a90b5cbc');
        $this->addSql('ALTER TABLE coprocessor DROP manufacturer_id');
        $this->addSql('ALTER TABLE coprocessor DROP processor_platform_type_id');
        $this->addSql('ALTER TABLE coprocessor DROP name');
        $this->addSql('ALTER TABLE coprocessor ADD CONSTRAINT FK_4D944CD6BF396750 FOREIGN KEY (id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE coprocessor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE coprocessor DROP CONSTRAINT FK_4D944CD6BF396750');
        $this->addSql('ALTER TABLE coprocessor ADD manufacturer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coprocessor ADD processor_platform_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coprocessor ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE coprocessor ADD CONSTRAINT fk_4d944cd6a23b42d FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE coprocessor ADD CONSTRAINT fk_4d944cd6a90b5cbc FOREIGN KEY (processor_platform_type_id) REFERENCES processor_platform_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4d944cd6a23b42d ON coprocessor (manufacturer_id)');
        $this->addSql('CREATE INDEX idx_4d944cd6a90b5cbc ON coprocessor (processor_platform_type_id)');
    }
}

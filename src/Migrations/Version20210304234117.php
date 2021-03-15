<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210304234117 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE processor_id_seq CASCADE');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT fk_29c04650a23b42d');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT fk_29c04650a90b5cbc');
        $this->addSql('DROP INDEX idx_29c04650a23b42d');
        $this->addSql('DROP INDEX idx_29c04650a90b5cbc');
        $this->addSql('ALTER TABLE processor DROP manufacturer_id');
        $this->addSql('ALTER TABLE processor DROP processor_platform_type_id');
        $this->addSql('ALTER TABLE processor DROP name');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT FK_29C04650BF396750 FOREIGN KEY (id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE processor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT FK_29C04650BF396750');
        $this->addSql('ALTER TABLE processor ADD manufacturer_id INT NOT NULL');
        $this->addSql('ALTER TABLE processor ADD processor_platform_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT fk_29c04650a23b42d FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT fk_29c04650a90b5cbc FOREIGN KEY (processor_platform_type_id) REFERENCES processor_platform_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_29c04650a23b42d ON processor (manufacturer_id)');
        $this->addSql('CREATE INDEX idx_29c04650a90b5cbc ON processor (processor_platform_type_id)');
    }
}

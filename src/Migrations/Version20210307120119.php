<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307120119 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE processor_platform_type_processor_platform_type (processor_platform_type_source INT NOT NULL, processor_platform_type_target INT NOT NULL, PRIMARY KEY(processor_platform_type_source, processor_platform_type_target))');
        $this->addSql('CREATE INDEX IDX_FFE4AFE1F2B96AA2 ON processor_platform_type_processor_platform_type (processor_platform_type_source)');
        $this->addSql('CREATE INDEX IDX_FFE4AFE1EB5C3A2D ON processor_platform_type_processor_platform_type (processor_platform_type_target)');
        $this->addSql('ALTER TABLE processor_platform_type_processor_platform_type ADD CONSTRAINT FK_FFE4AFE1F2B96AA2 FOREIGN KEY (processor_platform_type_source) REFERENCES processor_platform_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor_platform_type_processor_platform_type ADD CONSTRAINT FK_FFE4AFE1EB5C3A2D FOREIGN KEY (processor_platform_type_target) REFERENCES processor_platform_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE processor_platform_type_processor_platform_type');
    }
}

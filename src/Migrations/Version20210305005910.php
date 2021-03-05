<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210305005910 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE processor ADD l1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD l2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD l3_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT FK_29C046504B77EEB7 FOREIGN KEY (l1_id) REFERENCES cache_size (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT FK_29C0465059C24159 FOREIGN KEY (l2_id) REFERENCES cache_size (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT FK_29C04650E17E263C FOREIGN KEY (l3_id) REFERENCES cache_size (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_29C046504B77EEB7 ON processor (l1_id)');
        $this->addSql('CREATE INDEX IDX_29C0465059C24159 ON processor (l2_id)');
        $this->addSql('CREATE INDEX IDX_29C04650E17E263C ON processor (l3_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT FK_29C046504B77EEB7');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT FK_29C0465059C24159');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT FK_29C04650E17E263C');
        $this->addSql('DROP INDEX IDX_29C046504B77EEB7');
        $this->addSql('DROP INDEX IDX_29C0465059C24159');
        $this->addSql('DROP INDEX IDX_29C04650E17E263C');
        $this->addSql('ALTER TABLE processor DROP l1_id');
        $this->addSql('ALTER TABLE processor DROP l2_id');
        $this->addSql('ALTER TABLE processor DROP l3_id');
    }
}

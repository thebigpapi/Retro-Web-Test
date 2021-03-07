<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210306234920 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE cache_method_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cache_ratio_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cache_method (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cache_ratio (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE processor ADD l1_cache_method_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD l2_cache_ratio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD l3_cache_ratio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT FK_29C046502D259658 FOREIGN KEY (l1_cache_method_id) REFERENCES cache_method (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT FK_29C04650B2FCD8D2 FOREIGN KEY (l2_cache_ratio_id) REFERENCES cache_ratio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT FK_29C046501C944943 FOREIGN KEY (l3_cache_ratio_id) REFERENCES cache_ratio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_29C046502D259658 ON processor (l1_cache_method_id)');
        $this->addSql('CREATE INDEX IDX_29C04650B2FCD8D2 ON processor (l2_cache_ratio_id)');
        $this->addSql('CREATE INDEX IDX_29C046501C944943 ON processor (l3_cache_ratio_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT FK_29C046502D259658');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT FK_29C04650B2FCD8D2');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT FK_29C046501C944943');
        $this->addSql('DROP SEQUENCE cache_method_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cache_ratio_id_seq CASCADE');
        $this->addSql('DROP TABLE cache_method');
        $this->addSql('DROP TABLE cache_ratio');
        $this->addSql('DROP INDEX IDX_29C046502D259658');
        $this->addSql('DROP INDEX IDX_29C04650B2FCD8D2');
        $this->addSql('DROP INDEX IDX_29C046501C944943');
        $this->addSql('ALTER TABLE processor DROP l1_cache_method_id');
        $this->addSql('ALTER TABLE processor DROP l2_cache_ratio_id');
        $this->addSql('ALTER TABLE processor DROP l3_cache_ratio_id');
    }
}

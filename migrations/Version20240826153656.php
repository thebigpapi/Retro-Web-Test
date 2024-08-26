<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240826153656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chip_known_issue (chip_id INT NOT NULL, known_issue_id INT NOT NULL, PRIMARY KEY(chip_id, known_issue_id))');
        $this->addSql('CREATE INDEX IDX_CC5F982EA588ADB3 ON chip_known_issue (chip_id)');
        $this->addSql('CREATE INDEX IDX_CC5F982E32096F65 ON chip_known_issue (known_issue_id)');
        $this->addSql('ALTER TABLE chip_known_issue ADD CONSTRAINT FK_CC5F982EA588ADB3 FOREIGN KEY (chip_id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chip_known_issue ADD CONSTRAINT FK_CC5F982E32096F65 FOREIGN KEY (known_issue_id) REFERENCES known_issue (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chip_known_issue DROP CONSTRAINT FK_CC5F982EA588ADB3');
        $this->addSql('ALTER TABLE chip_known_issue DROP CONSTRAINT FK_CC5F982E32096F65');
        $this->addSql('DROP TABLE chip_known_issue');
    }
}

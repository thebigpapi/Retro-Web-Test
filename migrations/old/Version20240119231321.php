<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240119231321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE known_issue ADD type SMALLINT DEFAULT NULL');
        $this->addSql('CREATE TABLE expansion_card_known_issue (expansion_card_id INT NOT NULL, known_issue_id INT NOT NULL, PRIMARY KEY(expansion_card_id, known_issue_id))');
        $this->addSql('CREATE INDEX IDX_3182827E96EC5E32 ON expansion_card_known_issue (expansion_card_id)');
        $this->addSql('CREATE INDEX IDX_3182827E32096F65 ON expansion_card_known_issue (known_issue_id)');
        $this->addSql('ALTER TABLE expansion_card_known_issue ADD CONSTRAINT FK_3182827E96EC5E32 FOREIGN KEY (expansion_card_id) REFERENCES expansion_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE expansion_card_known_issue ADD CONSTRAINT FK_3182827E32096F65 FOREIGN KEY (known_issue_id) REFERENCES known_issue (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE known_issue DROP type');
        $this->addSql('ALTER TABLE expansion_card_known_issue DROP CONSTRAINT FK_3182827E96EC5E32');
        $this->addSql('ALTER TABLE expansion_card_known_issue DROP CONSTRAINT FK_3182827E32096F65');
        $this->addSql('DROP TABLE expansion_card_known_issue');
    }
}

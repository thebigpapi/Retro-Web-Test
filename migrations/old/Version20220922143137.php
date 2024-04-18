<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922143137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creditor ADD license_id INT');
        $this->addSql('ALTER TABLE creditor ADD CONSTRAINT FK_3D82E92A460F904B FOREIGN KEY (license_id) REFERENCES license (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3D82E92A460F904B ON creditor (license_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE creditor DROP CONSTRAINT FK_3D82E92A460F904B');
        $this->addSql('DROP INDEX IDX_3D82E92A460F904B');
        $this->addSql('ALTER TABLE creditor DROP license_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820174154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_chip DROP CONSTRAINT fk_3ba8e6bebf396750');
        $this->addSql('ALTER TABLE processor DROP CONSTRAINT fk_29c04650bf396750');
        $this->addSql('ALTER TABLE processing_unit DROP CONSTRAINT fk_1f72dc5ebf396750');
        $this->addSql('DROP TABLE expansion_chip');
        $this->addSql('DROP TABLE processor');
        $this->addSql('DROP TABLE processing_unit');
        $this->addSql('ALTER TABLE chip DROP dtype');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE expansion_chip (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE processor (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE processing_unit (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE expansion_chip ADD CONSTRAINT fk_3ba8e6bebf396750 FOREIGN KEY (id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor ADD CONSTRAINT fk_29c04650bf396750 FOREIGN KEY (id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processing_unit ADD CONSTRAINT fk_1f72dc5ebf396750 FOREIGN KEY (id) REFERENCES chip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chip ADD dtype VARCHAR(255) NOT NULL');
    }
}

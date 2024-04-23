<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230830135905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chipset ADD test date');
        $this->addSql('UPDATE chipset SET test=to_date(release_date, \'yyyy-mm-dd\')');
        $this->addSql('ALTER TABLE chipset DROP release_date');
        $this->addSql('ALTER TABLE chipset ADD release_date date');
        $this->addSql('UPDATE chipset SET release_date=test');
        $this->addSql('ALTER TABLE chipset DROP test');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chipset ALTER release_date TYPE VARCHAR(255)');
        $this->addSql('DROP INDEX uniq_3d0ae6dc5e237e06');
        $this->addSql('CREATE UNIQUE INDEX uniq_3d0ae6dc5e237e06 ON manufacturer (full_name)');
    }
}

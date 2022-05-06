<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220506194008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE motherboard ADD slug VARCHAR(80)');

        //Slug creation
        $this->addSql("UPDATE motherboard mobo SET slug=left(lower(replace(replace(replace(replace(trim(replace(replace(replace(replace(replace(replace(replace(replace(concat(left(coalesce(coalesce(man.short_name, man.name), 'unknown'), 16), ' ', mobo.name), '\\', ' '), '#', ''), '&', 'and'), '+', ' '), '?', ''), '(', ' '), ')', ' '), '/', ' ')),' ','<>'),'><',''),'<>',' '), ' ', '-')), 43)
        FROM motherboard mobo2 LEFT JOIN manufacturer man ON man.id=mobo2.manufacturer_id WHERE mobo2.id=mobo.id ");
        
        //Making all slugs unique
        $this->addSql("UPDATE motherboard mobo SET slug=concat(left(mobo.slug, 41), '-', rowNo) FROM(SELECT id mid, slug, row_number() OVER (PARTITION BY slug ORDER BY slug) AS rowNo FROM motherboard mobo2) as req where rowNo > 1 and mid=mobo.id");
    
        $this->addSql('ALTER TABLE motherboard ALTER COLUMN slug SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7F7A0F2B989D9B62 ON motherboard (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_7F7A0F2B989D9B62');
        $this->addSql('ALTER TABLE motherboard DROP slug');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828163758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE large_file_chipset_part_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE large_file_chipset_part (id INT NOT NULL, large_file_id INT NOT NULL, chipset_part_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D54950A929EA72E8 ON large_file_chipset_part (large_file_id)');
        $this->addSql('CREATE INDEX IDX_D54950A936F0F0C7 ON large_file_chipset_part (chipset_part_id)');
        $this->addSql('ALTER TABLE large_file_chipset_part ADD CONSTRAINT FK_D54950A929EA72E8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_chipset_part ADD CONSTRAINT FK_D54950A936F0F0C7 FOREIGN KEY (chipset_part_id) REFERENCES chipset_part (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_chipset_part ADD is_recommended BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE manufacturer ALTER full_name DROP NOT NULL');
        $this->addSql('ALTER TABLE manufacturer ALTER name SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE large_file_chipset_part_id_seq CASCADE');
        $this->addSql('ALTER TABLE large_file_chipset_part DROP CONSTRAINT FK_D54950A929EA72E8');
        $this->addSql('ALTER TABLE large_file_chipset_part DROP CONSTRAINT FK_D54950A936F0F0C7');
        $this->addSql('DROP TABLE large_file_chipset_part');
        $this->addSql('DROP INDEX uniq_3d0ae6dc5e237e06');
        $this->addSql('ALTER TABLE manufacturer ALTER full_name SET NOT NULL');
        $this->addSql('ALTER TABLE manufacturer ALTER name DROP NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_3d0ae6dc5e237e06 ON manufacturer (full_name)');
    }
}

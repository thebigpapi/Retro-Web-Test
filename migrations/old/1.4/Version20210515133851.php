<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210515133851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE large_file_chipset_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE large_file_motherboard_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE large_file_chipset (id INT NOT NULL, large_file_id INT NOT NULL, chipset_id INT NOT NULL, is_recommended BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CA790FD229EA72E8 ON large_file_chipset (large_file_id)');
        $this->addSql('CREATE INDEX IDX_CA790FD2BC1433B9 ON large_file_chipset (chipset_id)');
        $this->addSql('CREATE TABLE large_file_motherboard (id INT NOT NULL, large_file_id INT NOT NULL, motherboard_id INT NOT NULL, is_recommended BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E989BE6729EA72E8 ON large_file_motherboard (large_file_id)');
        $this->addSql('CREATE INDEX IDX_E989BE676511E8A3 ON large_file_motherboard (motherboard_id)');
        $this->addSql('ALTER TABLE large_file_chipset ADD CONSTRAINT FK_CA790FD229EA72E8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_chipset ADD CONSTRAINT FK_CA790FD2BC1433B9 FOREIGN KEY (chipset_id) REFERENCES chipset (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_motherboard ADD CONSTRAINT FK_E989BE6729EA72E8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_motherboard ADD CONSTRAINT FK_E989BE676511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE chipset_large_file');
        $this->addSql('DROP TABLE motherboard_large_file');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE large_file_chipset_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE large_file_motherboard_id_seq CASCADE');
        $this->addSql('CREATE TABLE chipset_large_file (chipset_id INT NOT NULL, large_file_id INT NOT NULL, PRIMARY KEY(chipset_id, large_file_id))');
        $this->addSql('CREATE INDEX idx_3b1b4dc029ea72e8 ON chipset_large_file (large_file_id)');
        $this->addSql('CREATE INDEX idx_3b1b4dc0bc1433b9 ON chipset_large_file (chipset_id)');
        $this->addSql('CREATE TABLE motherboard_large_file (motherboard_id INT NOT NULL, large_file_id INT NOT NULL, PRIMARY KEY(motherboard_id, large_file_id))');
        $this->addSql('CREATE INDEX idx_ab8cbb076511e8a3 ON motherboard_large_file (motherboard_id)');
        $this->addSql('CREATE INDEX idx_ab8cbb0729ea72e8 ON motherboard_large_file (large_file_id)');
        $this->addSql('ALTER TABLE chipset_large_file ADD CONSTRAINT fk_3b1b4dc0bc1433b9 FOREIGN KEY (chipset_id) REFERENCES chipset (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_large_file ADD CONSTRAINT fk_3b1b4dc029ea72e8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_large_file ADD CONSTRAINT fk_ab8cbb076511e8a3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_large_file ADD CONSTRAINT fk_ab8cbb0729ea72e8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE large_file_chipset');
        $this->addSql('DROP TABLE large_file_motherboard');
    }
}

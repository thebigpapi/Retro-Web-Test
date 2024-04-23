<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219003934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE os_family_id_seq CASCADE');
        $this->addSql('ALTER TABLE os_flag_os_family DROP CONSTRAINT fk_52daada12b9b9ee5');
        $this->addSql('ALTER TABLE os_flag_os_family DROP CONSTRAINT fk_52daada18abd126a');
        $this->addSql('DROP TABLE os_flag_os_family');
        $this->addSql('DROP TABLE os_family');
        $this->addSql('ALTER TABLE chipset ALTER last_edited DROP DEFAULT');
        $this->addSql('ALTER TABLE large_file ALTER last_edited DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE os_family_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE os_flag_os_family (os_flag_id INT NOT NULL, os_family_id INT NOT NULL, PRIMARY KEY(os_flag_id, os_family_id))');
        $this->addSql('CREATE INDEX idx_52daada18abd126a ON os_flag_os_family (os_flag_id)');
        $this->addSql('CREATE INDEX idx_52daada12b9b9ee5 ON os_flag_os_family (os_family_id)');
        $this->addSql('CREATE TABLE os_family (id INT NOT NULL, name VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE os_flag_os_family ADD CONSTRAINT fk_52daada12b9b9ee5 FOREIGN KEY (os_family_id) REFERENCES os_family (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE os_flag_os_family ADD CONSTRAINT fk_52daada18abd126a FOREIGN KEY (os_flag_id) REFERENCES os_flag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file ALTER last_edited SET DEFAULT \'2019-04-30 00:00:00\'');
        $this->addSql('ALTER TABLE chipset ALTER last_edited SET DEFAULT \'2019-04-30 00:00:00\'');
    }
}

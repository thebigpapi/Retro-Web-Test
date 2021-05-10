<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210510214921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE os_family_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE os_flag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE os_family (id INT NOT NULL, name VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE os_flag (id INT NOT NULL, manufacturer_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, major_version VARCHAR(255) NOT NULL, minor_version VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_27D7F081A23B42D ON os_flag (manufacturer_id)');
        $this->addSql('CREATE TABLE os_flag_os_family (os_flag_id INT NOT NULL, os_family_id INT NOT NULL, PRIMARY KEY(os_flag_id, os_family_id))');
        $this->addSql('CREATE INDEX IDX_52DAADA18ABD126A ON os_flag_os_family (os_flag_id)');
        $this->addSql('CREATE INDEX IDX_52DAADA12B9B9EE5 ON os_flag_os_family (os_family_id)');
        $this->addSql('ALTER TABLE os_flag ADD CONSTRAINT FK_27D7F081A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE os_flag_os_family ADD CONSTRAINT FK_52DAADA18ABD126A FOREIGN KEY (os_flag_id) REFERENCES os_flag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE os_flag_os_family ADD CONSTRAINT FK_52DAADA12B9B9EE5 FOREIGN KEY (os_family_id) REFERENCES os_family (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE os_flag_os_family DROP CONSTRAINT FK_52DAADA12B9B9EE5');
        $this->addSql('ALTER TABLE os_flag_os_family DROP CONSTRAINT FK_52DAADA18ABD126A');
        $this->addSql('DROP SEQUENCE os_family_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE os_flag_id_seq CASCADE');
        $this->addSql('DROP TABLE os_family');
        $this->addSql('DROP TABLE os_flag');
        $this->addSql('DROP TABLE os_flag_os_family');
    }
}

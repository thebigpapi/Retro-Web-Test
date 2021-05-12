<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511211114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE large_file_media_type_flag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE large_file_os_flag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE large_file_media_type_flag (id INT NOT NULL, large_file_id INT NOT NULL, media_type_flag_id INT NOT NULL, count INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_10386AB129EA72E8 ON large_file_media_type_flag (large_file_id)');
        $this->addSql('CREATE INDEX IDX_10386AB1D04F219C ON large_file_media_type_flag (media_type_flag_id)');
        $this->addSql('CREATE TABLE large_file_os_flag (id INT NOT NULL, large_file_id INT NOT NULL, os_flag_id INT NOT NULL, unsure BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C873B20C29EA72E8 ON large_file_os_flag (large_file_id)');
        $this->addSql('CREATE INDEX IDX_C873B20C8ABD126A ON large_file_os_flag (os_flag_id)');
        $this->addSql('ALTER TABLE large_file_media_type_flag ADD CONSTRAINT FK_10386AB129EA72E8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_media_type_flag ADD CONSTRAINT FK_10386AB1D04F219C FOREIGN KEY (media_type_flag_id) REFERENCES media_type_flag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_os_flag ADD CONSTRAINT FK_C873B20C29EA72E8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_os_flag ADD CONSTRAINT FK_C873B20C8ABD126A FOREIGN KEY (os_flag_id) REFERENCES os_flag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE large_file_media_type_flag_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE large_file_os_flag_id_seq CASCADE');
        $this->addSql('DROP TABLE large_file_media_type_flag');
        $this->addSql('DROP TABLE large_file_os_flag');
    }
}

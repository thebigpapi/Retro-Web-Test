<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219005255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE large_file_os_flag_id_seq CASCADE');
        $this->addSql('ALTER TABLE large_file_os_flag DROP CONSTRAINT FK_C873B20C29EA72E8');
        $this->addSql('ALTER TABLE large_file_os_flag DROP CONSTRAINT FK_C873B20C8ABD126A');
        $this->addSql('ALTER TABLE large_file_os_flag DROP id');
        $this->addSql('ALTER TABLE large_file_os_flag DROP unsure');
        $this->addSql('ALTER TABLE large_file_os_flag ADD CONSTRAINT FK_C873B20C29EA72E8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_os_flag ADD CONSTRAINT FK_C873B20C8ABD126A FOREIGN KEY (os_flag_id) REFERENCES os_flag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_os_flag ADD PRIMARY KEY (large_file_id, os_flag_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE large_file_os_flag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE large_file_os_flag DROP CONSTRAINT fk_c873b20c29ea72e8');
        $this->addSql('ALTER TABLE large_file_os_flag DROP CONSTRAINT fk_c873b20c8abd126a');
        $this->addSql('DROP INDEX large_file_os_flag_pkey');
        $this->addSql('ALTER TABLE large_file_os_flag ADD id INT NOT NULL');
        $this->addSql('ALTER TABLE large_file_os_flag ADD unsure BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE large_file_os_flag ADD CONSTRAINT fk_c873b20c29ea72e8 FOREIGN KEY (large_file_id) REFERENCES large_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_os_flag ADD CONSTRAINT fk_c873b20c8abd126a FOREIGN KEY (os_flag_id) REFERENCES os_flag (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE large_file_os_flag ADD PRIMARY KEY (id)');
    }
}

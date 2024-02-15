<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215132350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE floppy_drive_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE floppy_drive_floppy_drive_type (floppy_drive_id INT NOT NULL, floppy_drive_type_id INT NOT NULL, PRIMARY KEY(floppy_drive_id, floppy_drive_type_id))');
        $this->addSql('CREATE INDEX IDX_8AA222E4A6A44FC6 ON floppy_drive_floppy_drive_type (floppy_drive_id)');
        $this->addSql('CREATE INDEX IDX_8AA222E490475B49 ON floppy_drive_floppy_drive_type (floppy_drive_type_id)');
        $this->addSql('CREATE TABLE floppy_drive_type (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE floppy_drive_floppy_drive_type ADD CONSTRAINT FK_8AA222E4A6A44FC6 FOREIGN KEY (floppy_drive_id) REFERENCES floppy_drive (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE floppy_drive_floppy_drive_type ADD CONSTRAINT FK_8AA222E490475B49 FOREIGN KEY (floppy_drive_type_id) REFERENCES floppy_drive_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE floppy_drive DROP density');
        $this->addSql('CREATE TABLE floppy_drive_type_audit (id SERIAL NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX type_9e9e8c12585aa122fc5415b2105fcb78_idx ON floppy_drive_type_audit (type)');
        $this->addSql('CREATE INDEX object_id_9e9e8c12585aa122fc5415b2105fcb78_idx ON floppy_drive_type_audit (object_id)');
        $this->addSql('CREATE INDEX discriminator_9e9e8c12585aa122fc5415b2105fcb78_idx ON floppy_drive_type_audit (discriminator)');
        $this->addSql('CREATE INDEX transaction_hash_9e9e8c12585aa122fc5415b2105fcb78_idx ON floppy_drive_type_audit (transaction_hash)');
        $this->addSql('CREATE INDEX blame_id_9e9e8c12585aa122fc5415b2105fcb78_idx ON floppy_drive_type_audit (blame_id)');
        $this->addSql('CREATE INDEX created_at_9e9e8c12585aa122fc5415b2105fcb78_idx ON floppy_drive_type_audit (created_at)');
        $this->addSql('COMMENT ON COLUMN floppy_drive_type_audit.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE floppy_drive_type_id_seq CASCADE');
        $this->addSql('ALTER TABLE floppy_drive_floppy_drive_type DROP CONSTRAINT FK_8AA222E4A6A44FC6');
        $this->addSql('ALTER TABLE floppy_drive_floppy_drive_type DROP CONSTRAINT FK_8AA222E490475B49');
        $this->addSql('DROP TABLE floppy_drive_floppy_drive_type');
        $this->addSql('DROP TABLE floppy_drive_type');
        $this->addSql('ALTER TABLE floppy_drive ADD density VARCHAR(255) NOT NULL');
        $this->addSql('DROP TABLE floppy_drive_type_audit');
    }
}

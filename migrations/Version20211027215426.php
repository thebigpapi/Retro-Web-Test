<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211027215426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE psuconnector_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE psuconnector (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE psuconnector_motherboard (psuconnector_id INT NOT NULL, motherboard_id INT NOT NULL, PRIMARY KEY(psuconnector_id, motherboard_id))');
        $this->addSql('CREATE INDEX IDX_DF1D9F99D6871168 ON psuconnector_motherboard (psuconnector_id)');
        $this->addSql('CREATE INDEX IDX_DF1D9F996511E8A3 ON psuconnector_motherboard (motherboard_id)');
        $this->addSql('ALTER TABLE psuconnector_motherboard ADD CONSTRAINT FK_DF1D9F99D6871168 FOREIGN KEY (psuconnector_id) REFERENCES psuconnector (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE psuconnector_motherboard ADD CONSTRAINT FK_DF1D9F996511E8A3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE processor_platform_type_motherboard');
        $this->addSql('ALTER TABLE manual ADD CONSTRAINT FK_10DBBEC482F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D0AE6DC5E237E06 ON manufacturer (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D0AE6DC3EE4B093 ON manufacturer (short_name)');
        $this->addSql('ALTER TABLE motherboard_processor ADD CONSTRAINT FK_2BE8FD2137BAC19A FOREIGN KEY (processor_id) REFERENCES processor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE psuconnector_motherboard DROP CONSTRAINT FK_DF1D9F99D6871168');
        $this->addSql('DROP SEQUENCE psuconnector_id_seq CASCADE');
        $this->addSql('CREATE TABLE processor_platform_type_motherboard (processor_platform_type_id INT NOT NULL, motherboard_id INT NOT NULL, PRIMARY KEY(processor_platform_type_id, motherboard_id))');
        $this->addSql('CREATE INDEX idx_91ac6702a90b5cbc ON processor_platform_type_motherboard (processor_platform_type_id)');
        $this->addSql('CREATE INDEX idx_91ac67026511e8a3 ON processor_platform_type_motherboard (motherboard_id)');
        $this->addSql('ALTER TABLE processor_platform_type_motherboard ADD CONSTRAINT fk_91ac67026511e8a3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE processor_platform_type_motherboard ADD CONSTRAINT fk_91ac6702a90b5cbc FOREIGN KEY (processor_platform_type_id) REFERENCES processor_platform_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE psuconnector');
        $this->addSql('DROP TABLE psuconnector_motherboard');
        $this->addSql('DROP INDEX UNIQ_3D0AE6DC5E237E06');
        $this->addSql('DROP INDEX UNIQ_3D0AE6DC3EE4B093');
        $this->addSql('ALTER TABLE motherboard_processor DROP CONSTRAINT FK_2BE8FD2137BAC19A');
        $this->addSql('ALTER TABLE manual DROP CONSTRAINT FK_10DBBEC482F1BAF4');
    }
}

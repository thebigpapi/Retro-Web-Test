<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220206133619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE chip_documentation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE expansion_connector_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE chip_documentation (id INT NOT NULL, chip_id INT DEFAULT NULL, language_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, link_name VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_10FB0BC8A588ADB3 ON chip_documentation (chip_id)');
        $this->addSql('CREATE INDEX IDX_10FB0BC882F1BAF4 ON chip_documentation (language_id)');
        //Removing redundant expansion slot
        $this->addSql('UPDATE motherboard_expansion_slot SET expansion_slot_id=2 where expansion_slot_id=22');
        $this->addSql('DELETE FROM expansion_slot WHERE id=22');
        //Creating new table
        $this->addSql('CREATE TABLE expansion_connector (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO expansion_connector (id, name) VALUES 
        (nextval(\'expansion_connector_id_seq\'), \'32-bit PCI\'),
        (nextval(\'expansion_connector_id_seq\'), \'64-bit PCI\'),
        (nextval(\'expansion_connector_id_seq\'), \'AGP\'),
        (nextval(\'expansion_connector_id_seq\'), \'8-bit ISA\'),
        (nextval(\'expansion_connector_id_seq\'), \'16-bit ISA\'),
        (nextval(\'expansion_connector_id_seq\'), \'EISA\'),
        (nextval(\'expansion_connector_id_seq\'), \'32-bit MCA\'),
        (nextval(\'expansion_connector_id_seq\'), \'16-bit MCA\'),
        (nextval(\'expansion_connector_id_seq\'), \'AMR\'),
        (nextval(\'expansion_connector_id_seq\'), \'CNR\'),
        (nextval(\'expansion_connector_id_seq\'), \'ACR\'),
        (nextval(\'expansion_connector_id_seq\'), \'ASUS Mediabus\'),
        (nextval(\'expansion_connector_id_seq\'), \'64-bit PCI-X\'),
        (nextval(\'expansion_connector_id_seq\'), \'PCIe x16\'),
        (nextval(\'expansion_connector_id_seq\'), \'PCIe x4\'),
        (nextval(\'expansion_connector_id_seq\'), \'PCIe x1\'),
        (nextval(\'expansion_connector_id_seq\'), \'32-bit mini-PCI\'),
        (nextval(\'expansion_connector_id_seq\'), \'ASUS WiFi Slot\'),
        (nextval(\'expansion_connector_id_seq\'), \'RAID Port\'),
        (nextval(\'expansion_connector_id_seq\'), \'ASRock HDMR\'),
        (nextval(\'expansion_connector_id_seq\'), \'PTI (Panel TV Out)\'),
        (nextval(\'expansion_connector_id_seq\'), \'HP/Compaq Multibay\'),
        (nextval(\'expansion_connector_id_seq\'), \'Ether-SCSI\'),
        (nextval(\'expansion_connector_id_seq\'), \'Intel AT-32\'),
        (nextval(\'expansion_connector_id_seq\'), \'32-bit CompactPCI\'),
        (nextval(\'expansion_connector_id_seq\'), \'PCMCIA\'),
        (nextval(\'expansion_connector_id_seq\'), \'PTI (Panel TV Out)\'),
        (nextval(\'expansion_connector_id_seq\'), \'AGP Pro\'),
        (nextval(\'expansion_connector_id_seq\'), \'VLB\'),
        (nextval(\'expansion_connector_id_seq\'), \'TV-Out/LCD Riser\'),
        (nextval(\'expansion_connector_id_seq\'), \'Mini-PCIe\'),
        (nextval(\'expansion_connector_id_seq\'), \'ASUS SupremeFX slot\')');
        $this->addSql('ALTER TABLE chip_documentation ADD CONSTRAINT FK_10FB0BC8A588ADB3 FOREIGN KEY (chip_id) REFERENCES chip (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chip_documentation ADD CONSTRAINT FK_10FB0BC882F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset_part ALTER rank DROP DEFAULT');
        //Adding relationship to expansion_connector
        $this->addSql('ALTER TABLE expansion_slot ADD connector_id INT');
        //AGP
        $this->addSql('UPDATE expansion_slot SET connector_id=3 WHERE (name ilike \'%agp%\' or id in (41, 30, 24, 25, 31, 29, 51, 50)) AND id not in(18, 19, 20)');
        //AGP Pro
        $this->addSql('UPDATE expansion_slot SET connector_id=28 WHERE (name ilike \'%agp pro%\')');
        //EISA
        $this->addSql('UPDATE expansion_slot SET connector_id=6 WHERE id in (7, 10, 36)');
        //asus Media bus
        $this->addSql('UPDATE expansion_slot SET connector_id=12 WHERE id in(8, 9)');
        //PCIe x16
        $this->addSql('UPDATE expansion_slot SET connector_id=14 WHERE id in(29)');
        //VLB
        $this->addSql('UPDATE expansion_slot SET connector_id=29 WHERE id in(43, 4)');
        //PCMCIA
        $this->addSql('UPDATE expansion_slot SET connector_id=26 WHERE id in(39, 40)');
        $this->addSql('UPDATE expansion_slot as es SET connector_id = (SELECT id from expansion_connector as ec WHERE es.name = ec.name LIMIT 1) WHERE connector_id is NULL');
        $this->addSql('ALTER TABLE expansion_slot ALTER connector_id SET NOT NULL');
        $this->addSql('ALTER TABLE expansion_slot ADD CONSTRAINT FK_3D8F7A624D085745 FOREIGN KEY (connector_id) REFERENCES expansion_connector (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3D8F7A624D085745 ON expansion_slot (connector_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expansion_slot DROP CONSTRAINT FK_3D8F7A624D085745');
        $this->addSql('DROP SEQUENCE chip_documentation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE expansion_connector_id_seq CASCADE');
        $this->addSql('DROP TABLE chip_documentation');
        $this->addSql('DROP TABLE expansion_connector');
        $this->addSql('DROP INDEX IDX_3D8F7A624D085745');
        $this->addSql('ALTER TABLE expansion_slot DROP connector_id');
        $this->addSql('ALTER TABLE chipset_part ALTER rank SET DEFAULT 1');
    }
}

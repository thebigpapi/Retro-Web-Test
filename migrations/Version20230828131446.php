<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828131446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE motherboard_processor DROP CONSTRAINT fk_2be8fd2137bac19a');
        $this->addSql('ALTER TABLE motherboard_processor DROP CONSTRAINT fk_2be8fd216511e8a3');
        $this->addSql('ALTER TABLE motherboard_coprocessor DROP CONSTRAINT fk_27036c4d44ebdbab');
        $this->addSql('ALTER TABLE motherboard_coprocessor DROP CONSTRAINT fk_27036c4d6511e8a3');
        $this->addSql('DROP TABLE motherboard_processor');
        $this->addSql('DROP TABLE motherboard_coprocessor');
        $this->addSql('ALTER TABLE chipset ALTER cached_name DROP DEFAULT');
        $this->addSql('DROP INDEX uniq_3d0ae6dc3ee4b093');
        $this->addSql('UPDATE manufacturer SET short_name=COALESCE(short_name, name)');
        $this->addSql('ALTER TABLE manufacturer RENAME COLUMN name TO full_name');
        $this->addSql('ALTER TABLE manufacturer RENAME COLUMN short_name TO name');
        //$this->addSql('CREATE UNIQUE INDEX UNIQ_3D0AE6DCDBC463C4 ON manufacturer (full_name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE motherboard_processor (motherboard_id INT NOT NULL, processor_id INT NOT NULL, PRIMARY KEY(motherboard_id, processor_id))');
        $this->addSql('CREATE INDEX idx_2be8fd216511e8a3 ON motherboard_processor (motherboard_id)');
        $this->addSql('CREATE INDEX idx_2be8fd2137bac19a ON motherboard_processor (processor_id)');
        $this->addSql('CREATE TABLE motherboard_coprocessor (motherboard_id INT NOT NULL, coprocessor_id INT NOT NULL, PRIMARY KEY(motherboard_id, coprocessor_id))');
        $this->addSql('CREATE INDEX idx_27036c4d6511e8a3 ON motherboard_coprocessor (motherboard_id)');
        $this->addSql('CREATE INDEX idx_27036c4d44ebdbab ON motherboard_coprocessor (coprocessor_id)');
        $this->addSql('ALTER TABLE motherboard_processor ADD CONSTRAINT fk_2be8fd2137bac19a FOREIGN KEY (processor_id) REFERENCES processor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_processor ADD CONSTRAINT fk_2be8fd216511e8a3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_coprocessor ADD CONSTRAINT fk_27036c4d44ebdbab FOREIGN KEY (coprocessor_id) REFERENCES coprocessor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motherboard_coprocessor ADD CONSTRAINT fk_27036c4d6511e8a3 FOREIGN KEY (motherboard_id) REFERENCES motherboard (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chipset ALTER cached_name SET DEFAULT \'\'');
        $this->addSql('DROP INDEX UNIQ_3D0AE6DCDBC463C4');
        $this->addSql('ALTER TABLE manufacturer RENAME COLUMN full_name TO short_name');
        $this->addSql('CREATE UNIQUE INDEX uniq_3d0ae6dc3ee4b093 ON manufacturer (short_name)');
    }
}

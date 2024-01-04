<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230830135905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

private function convertDate($dateString) {
    // Sprawdź, czy data jest null
    if ($dateString === null) {
        return null;
    }

    // Dla formatu <MM/DD/YY lub <MM/DD/YYYY
    if (preg_match('/<(\d{2})\/(\d{2})\/(\d{2,4})/', $dateString, $matches)) {
        $year = strlen($matches[3]) === 2 ? '19' . $matches[3] : $matches[3];
        return "{$year}-{$matches[1]}-{$matches[2]}";
    }
    // Dla formatu YYYY lub YYYY?
    elseif (preg_match('/^(\d{4})\??$/', $dateString, $matches)) {
        return "{$matches[1]}-01-01"; // Zakładamy pierwszy dzień roku
    }
    // Dla formatu YYYY-MM
    elseif (preg_match('/^\d{4}-\d{2}$/', $dateString)) {
        return "{$dateString}-01"; // Zakładamy pierwszy dzień miesiąca
    }
    // Dla formatu <MMMYY lub <MMMYYYY
    elseif (preg_match('/<([a-zA-Z]{3})(\d{2,4})/', $dateString, $matches)) {
        $month = $this->convertMonthNameToNumber($matches[1]);
        $year = strlen($matches[2]) === 2 ? '19' . $matches[2] : $matches[2];
        return $month ? "{$year}-{$month}-01" : null;
    }
    return null; // Nieznany format lub puste pole
}

private function convertMonthNameToNumber($monthName) {
    $months = [
        'Jan' => '01', 'Feb' => '02', 'Mar' => '03',
        'Apr' => '04', 'May' => '05', 'Jun' => '06',
        'Jul' => '07', 'Aug' => '08', 'Sep' => '09',
        'Oct' => '10', 'Nov' => '11', 'Dec' => '12'
    ];
    return $months[$monthName] ?? null;
}

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chipset ADD test date');
	$rows = $this->connection->fetchAllAssociative('SELECT id, release_date FROM chipset');
	foreach ($rows as $row) {
	    $formattedDate = $this->convertDate($row['release_date']);

	    // Aktualizacja tymczasowej kolumny
	    if ($formattedDate) {
	        $this->addSql('UPDATE chipset SET test = ? WHERE id = ?', [$formattedDate, $row['id']]);
	    }
	}

//        $this->addSql('UPDATE chipset SET test=to_date(release_date, \'yyyy-mm-dd\')');
        $this->addSql('ALTER TABLE chipset DROP release_date');
        $this->addSql('ALTER TABLE chipset ADD release_date date');
        $this->addSql('UPDATE chipset SET release_date=test');
        $this->addSql('ALTER TABLE chipset DROP test');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chipset ALTER release_date TYPE VARCHAR(255)');
        $this->addSql('DROP INDEX uniq_3d0ae6dc5e237e06');
        $this->addSql('CREATE UNIQUE INDEX uniq_3d0ae6dc5e237e06 ON manufacturer (full_name)');
    }
}

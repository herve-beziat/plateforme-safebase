<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240905214314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE backup_schedule (id INT AUTO_INCREMENT NOT NULL, database_connection_id INT NOT NULL, frequency VARCHAR(20) NOT NULL, time TIME NOT NULL, day_of_week INT DEFAULT NULL, day_of_month INT DEFAULT NULL, last_run DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', next_run DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2D8DDC40959B17A3 (database_connection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE backup_schedule ADD CONSTRAINT FK_2D8DDC40959B17A3 FOREIGN KEY (database_connection_id) REFERENCES database_connection (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE backup_schedule DROP FOREIGN KEY FK_2D8DDC40959B17A3');
        $this->addSql('DROP TABLE backup_schedule');
    }
}

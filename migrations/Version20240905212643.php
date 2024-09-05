<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240905212643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE backup (id INT AUTO_INCREMENT NOT NULL, database_connection_id INT NOT NULL, filename VARCHAR(255) NOT NULL, file_path VARCHAR(255) NOT NULL, size BIGINT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(20) NOT NULL, INDEX IDX_3FF0D1AC959B17A3 (database_connection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE backup ADD CONSTRAINT FK_3FF0D1AC959B17A3 FOREIGN KEY (database_connection_id) REFERENCES database_connection (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE backup DROP FOREIGN KEY FK_3FF0D1AC959B17A3');
        $this->addSql('DROP TABLE backup');
    }
}

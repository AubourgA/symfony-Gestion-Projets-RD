<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220503160046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tests (id INT AUTO_INCREMENT NOT NULL, critere VARCHAR(255) NOT NULL, pres VARCHAR(255) DEFAULT NULL, duedate VARCHAR(100) DEFAULT NULL, unit VARCHAR(15) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE materials CHANGE unit unit VARCHAR(5) DEFAULT \'g\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tests');
        $this->addSql('ALTER TABLE materials CHANGE unit unit VARCHAR(5) DEFAULT NULL');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220507083730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE results ADD tests_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE results ADD CONSTRAINT FK_9FA3E414F5D80971 FOREIGN KEY (tests_id) REFERENCES tests (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9FA3E414F5D80971 ON results (tests_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE results DROP FOREIGN KEY FK_9FA3E414F5D80971');
        $this->addSql('DROP INDEX UNIQ_9FA3E414F5D80971 ON results');
        $this->addSql('ALTER TABLE results DROP tests_id');
    }
}

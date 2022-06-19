<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220507112104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE results DROP INDEX UNIQ_9FA3E414F5D80971, ADD INDEX IDX_9FA3E414F5D80971 (tests_id)');
        $this->addSql('ALTER TABLE results CHANGE tests_id tests_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE results DROP INDEX IDX_9FA3E414F5D80971, ADD UNIQUE INDEX UNIQ_9FA3E414F5D80971 (tests_id)');
        $this->addSql('ALTER TABLE results CHANGE tests_id tests_id INT DEFAULT NULL');
    }
}

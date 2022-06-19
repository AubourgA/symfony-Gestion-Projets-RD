<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220422155320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) NOT NULL, goals LONGTEXT NOT NULL, testing_number INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formulas ADD projects_id INT NOT NULL');
        $this->addSql('ALTER TABLE formulas ADD CONSTRAINT FK_81D64DE51EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id)');
        $this->addSql('CREATE INDEX IDX_81D64DE51EDE0F55 ON formulas (projects_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formulas DROP FOREIGN KEY FK_81D64DE51EDE0F55');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP INDEX IDX_81D64DE51EDE0F55 ON formulas');
        $this->addSql('ALTER TABLE formulas DROP projects_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220423145501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formulas (id INT AUTO_INCREMENT NOT NULL, projects_id INT NOT NULL, subject VARCHAR(255) NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_81D64DE51EDE0F55 (projects_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material_formula (id INT AUTO_INCREMENT NOT NULL, idformula_id INT NOT NULL, id_material_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, unit VARCHAR(5) NOT NULL, INDEX IDX_D6AB832E68A37EBC (idformula_id), INDEX IDX_D6AB832EFB1A6198 (id_material_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materials (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, vendor VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, unit VARCHAR(5) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) NOT NULL, goals LONGTEXT NOT NULL, testing_number INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', time_forcast VARCHAR(100) DEFAULT NULL, status VARCHAR(100) NOT NULL, active INT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formulas ADD CONSTRAINT FK_81D64DE51EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE material_formula ADD CONSTRAINT FK_D6AB832E68A37EBC FOREIGN KEY (idformula_id) REFERENCES formulas (id)');
        $this->addSql('ALTER TABLE material_formula ADD CONSTRAINT FK_D6AB832EFB1A6198 FOREIGN KEY (id_material_id) REFERENCES materials (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material_formula DROP FOREIGN KEY FK_D6AB832E68A37EBC');
        $this->addSql('ALTER TABLE material_formula DROP FOREIGN KEY FK_D6AB832EFB1A6198');
        $this->addSql('ALTER TABLE formulas DROP FOREIGN KEY FK_81D64DE51EDE0F55');
        $this->addSql('DROP TABLE formulas');
        $this->addSql('DROP TABLE material_formula');
        $this->addSql('DROP TABLE materials');
        $this->addSql('DROP TABLE projects');
    }
}

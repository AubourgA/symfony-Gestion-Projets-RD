<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419155554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE material_formula (id INT AUTO_INCREMENT NOT NULL, idformula_id INT NOT NULL, id_material_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, unit VARCHAR(5) NOT NULL, INDEX IDX_D6AB832E68A37EBC (idformula_id), INDEX IDX_D6AB832EFB1A6198 (id_material_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE material_formula ADD CONSTRAINT FK_D6AB832E68A37EBC FOREIGN KEY (idformula_id) REFERENCES formulas (id)');
        $this->addSql('ALTER TABLE material_formula ADD CONSTRAINT FK_D6AB832EFB1A6198 FOREIGN KEY (id_material_id) REFERENCES materials (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE material_formula');
    }
}

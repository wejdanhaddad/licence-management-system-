<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425213931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE license ADD date_creation DATETIME NOT NULL, ADD date_expiration DATETIME NOT NULL');
        $this->addSql('ALTER TABLE produit ADD license_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27460F904B FOREIGN KEY (license_id) REFERENCES license (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27460F904B ON produit (license_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27460F904B');
        $this->addSql('DROP INDEX IDX_29A5EC27460F904B ON produit');
        $this->addSql('ALTER TABLE produit DROP license_id');
        $this->addSql('ALTER TABLE license DROP date_creation, DROP date_expiration');
    }
}

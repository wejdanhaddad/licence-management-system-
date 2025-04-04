<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250323015134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit ADD version_actuelle VARCHAR(50) NOT NULL, ADD type_licence VARCHAR(20) NOT NULL, ADD date_creation DATETIME NOT NULL, ADD date_derniere_mise_ajour DATETIME DEFAULT NULL, ADD statut TINYINT(1) NOT NULL, ADD modules_inclus JSON NOT NULL, ADD conditions_utilisation LONGTEXT NOT NULL, CHANGE prix prix NUMERIC(10, 2) DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP version_actuelle, DROP type_licence, DROP date_creation, DROP date_derniere_mise_ajour, DROP statut, DROP modules_inclus, DROP conditions_utilisation, CHANGE image image VARCHAR(255) NOT NULL, CHANGE prix prix DOUBLE PRECISION NOT NULL');
    }
}

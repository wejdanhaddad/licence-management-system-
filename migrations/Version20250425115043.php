<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425115043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS category (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, subject LONGTEXT NOT NULL, message LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS license (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, license_key VARCHAR(255) NOT NULL, expiration_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_5768F419C54B2 (license_key), INDEX IDX_5768F41919EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS produit (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, version_actuelle VARCHAR(50) NOT NULL, type_licence VARCHAR(20) NOT NULL, date_creation DATETIME NOT NULL, date_derniere_mise_ajour DATETIME DEFAULT NULL, statut TINYINT(1) NOT NULL, prix NUMERIC(10, 2) DEFAULT NULL, modules_inclus JSON NOT NULL, conditions_utilisation LONGTEXT NOT NULL, INDEX IDX_29A5EC2712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS user (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // Check if the foreign key exists before dropping it
        $this->addSql("SET @fk_name = (SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'license' AND COLUMN_NAME = 'client_id' AND TABLE_SCHEMA = DATABASE());");
        $this->addSql("SET @query = IF(@fk_name IS NOT NULL, CONCAT('ALTER TABLE license DROP FOREIGN KEY ', @fk_name), 'SELECT 1');");
        $this->addSql("PREPARE stmt FROM @query;");
        $this->addSql("EXECUTE stmt;");
        $this->addSql("DEALLOCATE PREPARE stmt;");

        // Add the foreign key constraint
        $this->addSql('ALTER TABLE license ADD CONSTRAINT FK_5768F41919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        
        // Check if the foreign key exists before dropping it
        $this->addSql("SET @fk_name = (SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'produit' AND COLUMN_NAME = 'category_id' AND TABLE_SCHEMA = DATABASE());");
        $this->addSql("SET @query = IF(@fk_name IS NOT NULL, CONCAT('ALTER TABLE produit DROP FOREIGN KEY ', @fk_name), 'SELECT 1');");
        $this->addSql("PREPARE stmt FROM @query;");
        $this->addSql("EXECUTE stmt;");
        $this->addSql("DEALLOCATE PREPARE stmt;");

        // Add the foreign key constraint
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE license DROP FOREIGN KEY FK_5768F41919EB6921');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2712469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE license');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE user');
    }
}

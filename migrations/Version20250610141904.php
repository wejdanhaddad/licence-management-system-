<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250610141904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE content_block (id INT IDENTITY NOT NULL, identifier NVARCHAR(255) NOT NULL, titre NVARCHAR(255) NOT NULL, contenu NVARCHAR(255) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('DROP TABLE Licenses');
        $this->addSql('DROP TABLE XPObjectType');
        $this->addSql('ALTER TABLE license_request ADD CONSTRAINT FK_D28EC4C419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_accessadmin');
        $this->addSql('CREATE SCHEMA db_backupoperator');
        $this->addSql('CREATE SCHEMA db_datareader');
        $this->addSql('CREATE SCHEMA db_datawriter');
        $this->addSql('CREATE SCHEMA db_ddladmin');
        $this->addSql('CREATE SCHEMA db_denydatareader');
        $this->addSql('CREATE SCHEMA db_denydatawriter');
        $this->addSql('CREATE SCHEMA db_owner');
        $this->addSql('CREATE SCHEMA db_securityadmin');
        $this->addSql('CREATE SCHEMA dbo');
        $this->addSql('CREATE TABLE Licenses (OID INT IDENTITY NOT NULL, LicenseKey NVARCHAR(100) COLLATE French_CI_AS, ClientId NVARCHAR(100) COLLATE French_CI_AS, ProductId NVARCHAR(100) COLLATE French_CI_AS, CategoryId NVARCHAR(100) COLLATE French_CI_AS, LicenseType NVARCHAR(100) COLLATE French_CI_AS, MaxActivations INT, CurrentActivations INT, IsBlocked BIT, StartDate DATETIME2(6), EndDate DATETIME2(6), OptimisticLockField INT, GCRecord INT, PRIMARY KEY (OID))');
        $this->addSql('CREATE NONCLUSTERED INDEX iGCRecord_Licenses ON Licenses (GCRecord)');
        $this->addSql('CREATE TABLE XPObjectType (OID INT IDENTITY NOT NULL, TypeName NVARCHAR(254) COLLATE French_CI_AS, AssemblyName NVARCHAR(254) COLLATE French_CI_AS, PRIMARY KEY (OID))');
        $this->addSql('CREATE UNIQUE NONCLUSTERED INDEX iTypeName_XPObjectType ON XPObjectType (TypeName) WHERE TypeName IS NOT NULL');
        $this->addSql('DROP TABLE content_block');
        $this->addSql('ALTER TABLE license_request DROP CONSTRAINT FK_D28EC4C419EB6921');
    }
}

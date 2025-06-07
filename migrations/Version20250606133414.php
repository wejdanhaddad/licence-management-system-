<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250606133414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE faq (id INT IDENTITY NOT NULL, question NVARCHAR(255) NOT NULL, answer VARCHAR(MAX) NOT NULL, PRIMARY KEY (id))');
        $this->addSql('DROP TABLE Licenses');
        $this->addSql('DROP TABLE XPObjectType');
        $this->addSql('ALTER TABLE license ALTER COLUMN client_id INT NOT NULL');
        $this->addSql('ALTER TABLE license ALTER COLUMN active BIT NOT NULL');
        $this->addSql('ALTER TABLE license ADD CONSTRAINT DF_5768F419_4B1EFC02 DEFAULT 0 FOR active');
        $this->addSql('ALTER TABLE license ADD CONSTRAINT FK_5768F41919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE license ADD CONSTRAINT FK_5768F419F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_5768F419F347EFB ON license (produit_id)');
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
        $this->addSql('DROP TABLE faq');
        $this->addSql('ALTER TABLE license DROP CONSTRAINT FK_5768F41919EB6921');
        $this->addSql('ALTER TABLE license DROP CONSTRAINT FK_5768F419F347EFB');
        $this->addSql('DROP INDEX IDX_5768F419F347EFB ON license');
        $this->addSql('ALTER TABLE license ALTER COLUMN client_id INT');
        $this->addSql('ALTER TABLE license DROP CONSTRAINT DF_5768F419_4B1EFC02');
        $this->addSql('ALTER TABLE license ALTER COLUMN active BIT NOT NULL');
    }
}

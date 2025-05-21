<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250426223433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD full_name VARCHAR(255) NOT NULL, ADD username VARCHAR(255) NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP nom, DROP telephone');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON client (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455F85E0677 ON client (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_C7440455E7927C74 ON client');
        $this->addSql('DROP INDEX UNIQ_C7440455F85E0677 ON client');
        $this->addSql('ALTER TABLE client ADD nom VARCHAR(255) NOT NULL, ADD telephone VARCHAR(255) NOT NULL, DROP full_name, DROP username, DROP password');
    }
}

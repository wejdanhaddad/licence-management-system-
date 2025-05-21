<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425192838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE license DROP FOREIGN KEY FK_license_client');
        $this->addSql('DROP INDEX IDX_5768F419A76ED39 ON license');
        $this->addSql('DROP INDEX IDX_5768F419A76ED395 ON license');
        $this->addSql('DROP INDEX IDX_license_client ON license');
        $this->addSql('ALTER TABLE license ADD active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE license DROP active');
        $this->addSql('ALTER TABLE license ADD CONSTRAINT FK_license_client FOREIGN KEY (id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5768F419A76ED39 ON license (client_id)');
        $this->addSql('CREATE INDEX IDX_5768F419A76ED395 ON license (client_id)');
        $this->addSql('CREATE INDEX IDX_license_client ON license (id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424135456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // Check if the column already exists before adding it
        $schemaManager = $this->connection->createSchemaManager();
        $columns = $schemaManager->listTableColumns('license');

        if (!array_key_exists('user_id', $columns)) {
            $this->addSql('ALTER TABLE license ADD user_id INT NOT NULL');
            $this->addSql('ALTER TABLE license ADD CONSTRAINT FK_5768F419A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
            $this->addSql('CREATE INDEX IDX_5768F419A76ED395 ON license (user_id)');
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE license DROP FOREIGN KEY FK_5768F419A76ED395');
        $this->addSql('DROP INDEX IDX_5768F419A76ED395 ON license');
        $this->addSql('ALTER TABLE license DROP user_id');
    }
}

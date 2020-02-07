<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200206102445 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE groupe RENAME INDEX idx_6dc044c5a9fa2f6b TO IDX_4B98C21A9FA2F6B');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(20) NOT NULL, DROP roles');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE groupe RENAME INDEX idx_4b98c21a9fa2f6b TO IDX_6DC044C5A9FA2F6B');
        $this->addSql('ALTER TABLE user ADD roles JSON DEFAULT NULL, DROP role');
    }
}

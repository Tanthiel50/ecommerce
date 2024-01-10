<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109135015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Images (id INT AUTO_INCREMENT NOT NULL, Products_id INT DEFAULT NULL, alt VARCHAR(255) DEFAULT NULL, INDEX IDX_E01FBE6A6C8A81A9 (Products_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Images ADD CONSTRAINT FK_E01FBE6A6C8A81A9 FOREIGN KEY (Products_id) REFERENCES Products (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Images DROP FOREIGN KEY FK_E01FBE6A6C8A81A9');
        $this->addSql('DROP TABLE Images');
    }
}

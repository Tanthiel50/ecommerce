<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109134728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reviews ADD stars_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FFFEAC122 FOREIGN KEY (stars_id) REFERENCES stars (id)');
        $this->addSql('CREATE INDEX IDX_6970EB0FFFEAC122 ON reviews (stars_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FFFEAC122');
        $this->addSql('DROP INDEX IDX_6970EB0FFFEAC122 ON reviews');
        $this->addSql('ALTER TABLE reviews DROP stars_id');
    }
}

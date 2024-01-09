<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109133954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reviews ADD id_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6970EB0F79F37AE5 ON reviews (id_user_id)');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL, ADD pseudo VARCHAR(255) DEFAULT NULL, ADD adress LONGTEXT DEFAULT NULL, ADD zipcode VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL');
        $this->addSql("ALTER TABLE user ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F79F37AE5');
        $this->addSql('DROP INDEX IDX_6970EB0F79F37AE5 ON reviews');
        $this->addSql('ALTER TABLE reviews DROP id_user_id');
        $this->addSql('ALTER TABLE user DROP first_name, DROP last_name, DROP pseudo, DROP adress, DROP zipcode, DROP city, DROP created_at');
    }
}

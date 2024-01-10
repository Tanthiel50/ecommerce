<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109133118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, id_product_id INT DEFAULT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6970EB0FE00EE68D (id_product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT DEFAULT NULL, discount VARCHAR(255) DEFAULT NULL, date_begin DATETIME DEFAULT NULL, date_end DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stars (id INT AUTO_INCREMENT NOT NULL, rating VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FE00EE68D FOREIGN KEY (id_product_id) REFERENCES Products (id)');
        $this->addSql('ALTER TABLE Products ADD sales_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Products ADD CONSTRAINT FK_B3BA5A5AA4522A07 FOREIGN KEY (sales_id) REFERENCES sales (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5AA4522A07 ON Products (sales_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Products DROP FOREIGN KEY FK_B3BA5A5AA4522A07');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FE00EE68D');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE sales');
        $this->addSql('DROP TABLE stars');
        $this->addSql('DROP TABLE User');
        $this->addSql('DROP INDEX IDX_B3BA5A5AA4522A07 ON Products');
        $this->addSql('ALTER TABLE Products DROP sales_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240113134608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_details_products DROP FOREIGN KEY FK_BBFA3DCD6C8A81A9');
        $this->addSql('ALTER TABLE order_details_products DROP FOREIGN KEY FK_BBFA3DCD8C0FA77');
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C14584665A');
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C1DD4481AD');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F79F37AE5');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FE00EE68D');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0FFFEAC122');
        $this->addSql('DROP TABLE order_details_products');
        $this->addSql('DROP TABLE stars');
        $this->addSql('DROP TABLE order_details');
        $this->addSql('DROP TABLE reviews');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_details_products (order_details_id INT NOT NULL, products_id INT NOT NULL, INDEX IDX_BBFA3DCD6C8A81A9 (products_id), INDEX IDX_BBFA3DCD8C0FA77 (order_details_id), PRIMARY KEY(order_details_id, products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE stars (id INT AUTO_INCREMENT NOT NULL, rating VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE order_details (id INT AUTO_INCREMENT NOT NULL, id_order_id INT DEFAULT NULL, product_id INT DEFAULT NULL, quantity DOUBLE PRECISION DEFAULT NULL, price NUMERIC(10, 0) DEFAULT NULL, INDEX IDX_845CA2C14584665A (product_id), INDEX IDX_845CA2C1DD4481AD (id_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, id_product_id INT DEFAULT NULL, id_user_id INT DEFAULT NULL, stars_id INT DEFAULT NULL, content LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6970EB0F79F37AE5 (id_user_id), INDEX IDX_6970EB0FE00EE68D (id_product_id), INDEX IDX_6970EB0FFFEAC122 (stars_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE order_details_products ADD CONSTRAINT FK_BBFA3DCD6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_details_products ADD CONSTRAINT FK_BBFA3DCD8C0FA77 FOREIGN KEY (order_details_id) REFERENCES order_details (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C14584665A FOREIGN KEY (product_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C1DD4481AD FOREIGN KEY (id_order_id) REFERENCES orders (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FE00EE68D FOREIGN KEY (id_product_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FFFEAC122 FOREIGN KEY (stars_id) REFERENCES stars (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}

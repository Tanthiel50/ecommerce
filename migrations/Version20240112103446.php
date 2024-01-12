<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112103446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_details (id INT AUTO_INCREMENT NOT NULL, id_order_id INT DEFAULT NULL, quantity DOUBLE PRECISION DEFAULT NULL, price NUMERIC(10, 0) DEFAULT NULL, INDEX IDX_845CA2C1DD4481AD (id_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_details_products (order_details_id INT NOT NULL, products_id INT NOT NULL, INDEX IDX_BBFA3DCD8C0FA77 (order_details_id), INDEX IDX_BBFA3DCD6C8A81A9 (products_id), PRIMARY KEY(order_details_id, products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, id_user_order_id INT DEFAULT NULL, date DATE DEFAULT NULL, total NUMERIC(10, 2) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, INDEX IDX_E52FFDEED33A585D (id_user_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C1DD4481AD FOREIGN KEY (id_order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE order_details_products ADD CONSTRAINT FK_BBFA3DCD8C0FA77 FOREIGN KEY (order_details_id) REFERENCES order_details (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_details_products ADD CONSTRAINT FK_BBFA3DCD6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEED33A585D FOREIGN KEY (id_user_order_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C1DD4481AD');
        $this->addSql('ALTER TABLE order_details_products DROP FOREIGN KEY FK_BBFA3DCD8C0FA77');
        $this->addSql('ALTER TABLE order_details_products DROP FOREIGN KEY FK_BBFA3DCD6C8A81A9');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEED33A585D');
        $this->addSql('DROP TABLE order_details');
        $this->addSql('DROP TABLE order_details_products');
        $this->addSql('DROP TABLE orders');
    }
}

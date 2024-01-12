<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240111161050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5AA4522A07');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AA4522A07 FOREIGN KEY (sales_id) REFERENCES sales (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5AA4522A07');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AA4522A07 FOREIGN KEY (sales_id) REFERENCES sales (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}

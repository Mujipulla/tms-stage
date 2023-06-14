<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230602082009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_support_pdf (product_id INT NOT NULL, support_pdf_id INT NOT NULL, INDEX IDX_B962CC3B4584665A (product_id), INDEX IDX_B962CC3BD9E529E2 (support_pdf_id), PRIMARY KEY(product_id, support_pdf_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE support_pdf (id INT AUTO_INCREMENT NOT NULL, pdfname VARCHAR(255) NOT NULL, pdf_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_support_pdf ADD CONSTRAINT FK_B962CC3B4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_support_pdf ADD CONSTRAINT FK_B962CC3BD9E529E2 FOREIGN KEY (support_pdf_id) REFERENCES support_pdf (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_support_pdf DROP FOREIGN KEY FK_B962CC3B4584665A');
        $this->addSql('ALTER TABLE product_support_pdf DROP FOREIGN KEY FK_B962CC3BD9E529E2');
        $this->addSql('DROP TABLE product_support_pdf');
        $this->addSql('DROP TABLE support_pdf');
    }
}

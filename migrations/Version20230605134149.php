<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605134149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_details ADD pdfname_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_details ADD CONSTRAINT FK_845CA2C1EEB3D7D2 FOREIGN KEY (pdfname_id) REFERENCES support_pdf (id)');
        $this->addSql('CREATE INDEX IDX_845CA2C1EEB3D7D2 ON order_details (pdfname_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_details DROP FOREIGN KEY FK_845CA2C1EEB3D7D2');
        $this->addSql('DROP INDEX IDX_845CA2C1EEB3D7D2 ON order_details');
        $this->addSql('ALTER TABLE order_details DROP pdfname_id');
    }
}

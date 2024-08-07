<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240503043131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'ADD Mercurial Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mercurials (id INT AUTO_INCREMENT NOT NULL, supplier_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, import_date DATETIME NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_52CED1A62ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mercurials ADD CONSTRAINT FK_52CED1A62ADD6D8C FOREIGN KEY (supplier_id) REFERENCES suppliers (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mercurials DROP FOREIGN KEY FK_52CED1A62ADD6D8C');
        $this->addSql('DROP TABLE mercurials');
    }
}

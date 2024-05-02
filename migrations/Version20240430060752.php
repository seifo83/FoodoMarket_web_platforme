<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430060752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Suppliers Table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE suppliers (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, product_type VARCHAR(255) NOT NULL, notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_AC28B95CE7927C74 (email), INDEX IDX_AC28B95CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE suppliers ADD CONSTRAINT FK_AC28B95CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE suppliers DROP FOREIGN KEY FK_AC28B95CA76ED395');
        $this->addSql('DROP TABLE suppliers');
    }
}

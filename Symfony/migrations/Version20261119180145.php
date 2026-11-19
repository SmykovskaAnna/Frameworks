<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261119180145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exhibit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, author VARCHAR(255) NOT NULL, creation_date DATE NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE exhibition (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE exhibition_exhibit (id INT AUTO_INCREMENT NOT NULL, display_order INT NOT NULL, exhibition_id INT NOT NULL, exhibit_id INT NOT NULL, INDEX IDX_314CD8982A7D4494 (exhibition_id), INDEX IDX_314CD8982E5CE433 (exhibit_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, purchase_date DATETIME NOT NULL, price NUMERIC(10, 2) NOT NULL, ticket_type VARCHAR(50) NOT NULL, visitor_id INT NOT NULL, exhibition_id INT NOT NULL, INDEX IDX_97A0ADA370BEE6D (visitor_id), INDEX IDX_97A0ADA32A7D4494 (exhibition_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE visitor (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id))');
        $this->addSql('ALTER TABLE exhibition_exhibit ADD CONSTRAINT FK_314CD8982A7D4494 FOREIGN KEY (exhibition_id) REFERENCES exhibition (id)');
        $this->addSql('ALTER TABLE exhibition_exhibit ADD CONSTRAINT FK_314CD8982E5CE433 FOREIGN KEY (exhibit_id) REFERENCES exhibit (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA370BEE6D FOREIGN KEY (visitor_id) REFERENCES visitor (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA32A7D4494 FOREIGN KEY (exhibition_id) REFERENCES exhibition (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exhibition_exhibit DROP FOREIGN KEY FK_314CD8982A7D4494');
        $this->addSql('ALTER TABLE exhibition_exhibit DROP FOREIGN KEY FK_314CD8982E5CE433');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA370BEE6D');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA32A7D4494');
        $this->addSql('DROP TABLE exhibit');
        $this->addSql('DROP TABLE exhibition');
        $this->addSql('DROP TABLE exhibition_exhibit');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE visitor');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

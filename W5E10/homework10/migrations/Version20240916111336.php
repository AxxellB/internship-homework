<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240916111336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE authors (id INT AUTO_INCREMENT NOT NULL, books_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, year_of_birth DATE DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, INDEX IDX_8E0C2A517DD8AC20 (books_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE books (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, isbn VARCHAR(255) NOT NULL, year_of_publishing DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE books_editors (books_id INT NOT NULL, editors_id INT NOT NULL, INDEX IDX_3904E2FB7DD8AC20 (books_id), INDEX IDX_3904E2FB98722532 (editors_id), PRIMARY KEY(books_id, editors_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE books_genres (books_id INT NOT NULL, genres_id INT NOT NULL, INDEX IDX_6C215D1A7DD8AC20 (books_id), INDEX IDX_6C215D1A6A3B2603 (genres_id), PRIMARY KEY(books_id, genres_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editors (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, editor_number VARCHAR(255) NOT NULL, specialty VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genres (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE authors ADD CONSTRAINT FK_8E0C2A517DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id)');
        $this->addSql('ALTER TABLE books_editors ADD CONSTRAINT FK_3904E2FB7DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE books_editors ADD CONSTRAINT FK_3904E2FB98722532 FOREIGN KEY (editors_id) REFERENCES editors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE books_genres ADD CONSTRAINT FK_6C215D1A7DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE books_genres ADD CONSTRAINT FK_6C215D1A6A3B2603 FOREIGN KEY (genres_id) REFERENCES genres (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE authors DROP FOREIGN KEY FK_8E0C2A517DD8AC20');
        $this->addSql('ALTER TABLE books_editors DROP FOREIGN KEY FK_3904E2FB7DD8AC20');
        $this->addSql('ALTER TABLE books_editors DROP FOREIGN KEY FK_3904E2FB98722532');
        $this->addSql('ALTER TABLE books_genres DROP FOREIGN KEY FK_6C215D1A7DD8AC20');
        $this->addSql('ALTER TABLE books_genres DROP FOREIGN KEY FK_6C215D1A6A3B2603');
        $this->addSql('DROP TABLE authors');
        $this->addSql('DROP TABLE books');
        $this->addSql('DROP TABLE books_editors');
        $this->addSql('DROP TABLE books_genres');
        $this->addSql('DROP TABLE editors');
        $this->addSql('DROP TABLE genres');
    }
}

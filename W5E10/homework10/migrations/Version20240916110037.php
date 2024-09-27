<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240916110037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE books_editors DROP FOREIGN KEY FK_3904E2FB7DD8AC20');
        $this->addSql('ALTER TABLE books_editors DROP FOREIGN KEY FK_3904E2FB98722532');
        $this->addSql('ALTER TABLE authors DROP FOREIGN KEY FK_8E0C2A517DD8AC20');
        $this->addSql('ALTER TABLE books_genres DROP FOREIGN KEY FK_6C215D1A6A3B2603');
        $this->addSql('ALTER TABLE books_genres DROP FOREIGN KEY FK_6C215D1A7DD8AC20');
        $this->addSql('DROP TABLE books_editors');
        $this->addSql('DROP TABLE authors');
        $this->addSql('DROP TABLE genres');
        $this->addSql('DROP TABLE editors');
        $this->addSql('DROP TABLE books');
        $this->addSql('DROP TABLE books_genres');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE books_editors (books_id INT NOT NULL, editors_id INT NOT NULL, INDEX IDX_3904E2FB7DD8AC20 (books_id), INDEX IDX_3904E2FB98722532 (editors_id), PRIMARY KEY(books_id, editors_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE authors (id INT AUTO_INCREMENT NOT NULL, books_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, date_of_birth DATE NOT NULL, nationality VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, INDEX IDX_8E0C2A517DD8AC20 (books_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE genres (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE editors (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, editor_number VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, specialty VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE books (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, isbn VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, year_of_publishing DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE books_genres (books_id INT NOT NULL, genres_id INT NOT NULL, INDEX IDX_6C215D1A7DD8AC20 (books_id), INDEX IDX_6C215D1A6A3B2603 (genres_id), PRIMARY KEY(books_id, genres_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE books_editors ADD CONSTRAINT FK_3904E2FB7DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE books_editors ADD CONSTRAINT FK_3904E2FB98722532 FOREIGN KEY (editors_id) REFERENCES editors (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE authors ADD CONSTRAINT FK_8E0C2A517DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE books_genres ADD CONSTRAINT FK_6C215D1A6A3B2603 FOREIGN KEY (genres_id) REFERENCES genres (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE books_genres ADD CONSTRAINT FK_6C215D1A7DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}

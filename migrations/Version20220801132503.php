<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220801132503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, nickname VARCHAR(180) DEFAULT NULL, wallet DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(180) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7D3656A4E7927C74 (email), UNIQUE INDEX UNIQ_7D3656A45E237E06 (name), UNIQUE INDEX UNIQ_7D3656A4989D9B62 (slug), INDEX IDX_7D3656A4F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, game_id INT NOT NULL, content LONGTEXT NOT NULL, up_votes INT NOT NULL, down_votes INT NOT NULL, rank DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526C9B6B5FBA (account_id), INDEX IDX_9474526CE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, nationality VARCHAR(128) NOT NULL, url_flag VARCHAR(255) DEFAULT NULL, code VARCHAR(2) NOT NULL, name VARCHAR(180) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5373C9665E237E06 (name), UNIQUE INDEX UNIQ_5373C966989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, publisher_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, published_at DATETIME NOT NULL, description LONGTEXT NOT NULL, thumbnail_cover VARCHAR(255) DEFAULT NULL, thumbnail_logo VARCHAR(255) DEFAULT NULL, name VARCHAR(180) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_232B318C5E237E06 (name), UNIQUE INDEX UNIQ_232B318C989D9B62 (slug), INDEX IDX_232B318C40C86FCE (publisher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_country (game_id INT NOT NULL, country_id INT NOT NULL, INDEX IDX_C6B1B649E48FD905 (game_id), INDEX IDX_C6B1B649F92F3E70 (country_id), PRIMARY KEY(game_id, country_id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_genre (game_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_B1634A77E48FD905 (game_id), INDEX IDX_B1634A774296D31F (genre_id), PRIMARY KEY(game_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_835033F85E237E06 (name), UNIQUE INDEX UNIQ_835033F8989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
        $this->addSql('CREATE TABLE library (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, account_id INT DEFAULT NULL, installed TINYINT(1) DEFAULT 0 NOT NULL, game_time INT DEFAULT 0 NOT NULL, last_used_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_A18098BCE48FD905 (game_id), INDEX IDX_A18098BC9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publisher (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, website VARCHAR(180) NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(180) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_9CE8D5465E237E06 (name), UNIQUE INDEX UNIQ_9CE8D546989D9B62 (slug), INDEX IDX_9CE8D546F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C40C86FCE FOREIGN KEY (publisher_id) REFERENCES publisher (id)');
        $this->addSql('ALTER TABLE game_country ADD CONSTRAINT FK_C6B1B649E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_country ADD CONSTRAINT FK_C6B1B649F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_genre ADD CONSTRAINT FK_B1634A77E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_genre ADD CONSTRAINT FK_B1634A774296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE library ADD CONSTRAINT FK_A18098BCE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE library ADD CONSTRAINT FK_A18098BC9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE publisher ADD CONSTRAINT FK_9CE8D546F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9B6B5FBA');
        $this->addSql('ALTER TABLE library DROP FOREIGN KEY FK_A18098BC9B6B5FBA');
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A4F92F3E70');
        $this->addSql('ALTER TABLE game_country DROP FOREIGN KEY FK_C6B1B649F92F3E70');
        $this->addSql('ALTER TABLE publisher DROP FOREIGN KEY FK_9CE8D546F92F3E70');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CE48FD905');
        $this->addSql('ALTER TABLE game_country DROP FOREIGN KEY FK_C6B1B649E48FD905');
        $this->addSql('ALTER TABLE game_genre DROP FOREIGN KEY FK_B1634A77E48FD905');
        $this->addSql('ALTER TABLE library DROP FOREIGN KEY FK_A18098BCE48FD905');
        $this->addSql('ALTER TABLE game_genre DROP FOREIGN KEY FK_B1634A774296D31F');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C40C86FCE');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_country');
        $this->addSql('DROP TABLE game_genre');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE library');
        $this->addSql('DROP TABLE publisher');
    }
}

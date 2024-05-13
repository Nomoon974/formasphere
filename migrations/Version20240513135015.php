<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513135015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE documents (id INT AUTO_INCREMENT NOT NULL, space_id INT NOT NULL, user_id INT NOT NULL, link VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, timestamp DATETIME NOT NULL, INDEX IDX_A2B0728823575340 (space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, space_id INT NOT NULL, text LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_885DBAFAA76ED395 (user_id), INDEX IDX_885DBAFA23575340 (space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B0728823575340 FOREIGN KEY (space_id) REFERENCES spaces (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA23575340 FOREIGN KEY (space_id) REFERENCES spaces (id)');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9487CA85');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9D86650F');
        $this->addSql('DROP INDEX IDX_9474526C9487CA85 ON comment');
        $this->addSql('DROP INDEX IDX_9474526C9D86650F ON comment');
        $this->addSql('ALTER TABLE comment ADD user_id_id INT NOT NULL, ADD content_id_id INT NOT NULL, DROP user_id, DROP content_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9487CA85 FOREIGN KEY (content_id_id) REFERENCES contents (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9474526C9487CA85 ON comment (content_id_id)');
        $this->addSql('CREATE INDEX IDX_9474526C9D86650F ON comment (user_id_id)');
        $this->addSql('ALTER TABLE contents ADD post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contents ADD CONSTRAINT FK_B4FA11774B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
        $this->addSql('CREATE INDEX IDX_B4FA11774B89032C ON contents (post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contents DROP FOREIGN KEY FK_B4FA11774B89032C');
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B0728823575340');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAA76ED395');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA23575340');
        $this->addSql('DROP TABLE documents');
        $this->addSql('DROP TABLE posts');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9D86650F');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9487CA85');
        $this->addSql('DROP INDEX IDX_9474526C9D86650F ON comment');
        $this->addSql('DROP INDEX IDX_9474526C9487CA85 ON comment');
        $this->addSql('ALTER TABLE comment ADD user_id INT NOT NULL, ADD content_id INT NOT NULL, DROP user_id_id, DROP content_id_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9487CA85 FOREIGN KEY (content_id) REFERENCES contents (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9474526C9D86650F ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526C9487CA85 ON comment (content_id)');
        $this->addSql('DROP INDEX IDX_B4FA11774B89032C ON contents');
        $this->addSql('ALTER TABLE contents DROP post_id');
    }
}

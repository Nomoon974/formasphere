<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240528080732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archiving (id INT AUTO_INCREMENT NOT NULL, space_id INT DEFAULT NULL, archiving_date DATETIME NOT NULL, reason LONGTEXT DEFAULT NULL, deletion_date DATETIME DEFAULT NULL, INDEX IDX_A84564EA23575340 (space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat_message (id INT AUTO_INCREMENT NOT NULL, chat_id_id INT NOT NULL, user_id_id INT NOT NULL, text LONGTEXT NOT NULL, timestamp DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_FAB3FC167E3973CC (chat_id_id), INDEX IDX_FAB3FC169D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chats (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, space_id INT DEFAULT NULL, INDEX IDX_2D68180FA76ED395 (user_id), INDEX IDX_2D68180F23575340 (space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, post_id INT NOT NULL, text LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526C4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contents (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, space_id INT NOT NULL, post_id INT DEFAULT NULL, content_type VARCHAR(255) NOT NULL, content_link VARCHAR(255) NOT NULL, category VARCHAR(255) DEFAULT NULL, publication_date DATETIME NOT NULL, INDEX IDX_B4FA1177A76ED395 (user_id), INDEX IDX_B4FA117723575340 (space_id), INDEX IDX_B4FA11774B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documents (id INT AUTO_INCREMENT NOT NULL, space_id INT NOT NULL, user_id INT NOT NULL, link VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, timestamp DATETIME NOT NULL, INDEX IDX_A2B0728823575340 (space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, program_id INT DEFAULT NULL, module_title VARCHAR(100) NOT NULL, key_point LONGTEXT NOT NULL, duration INT DEFAULT NULL, prerequisities LONGTEXT DEFAULT NULL, INDEX IDX_C2426283EB8070A (program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, body LONGTEXT NOT NULL, state VARCHAR(255) NOT NULL, notification_type VARCHAR(255) NOT NULL, notification_date DATETIME NOT NULL, associated_link VARCHAR(255) DEFAULT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, space_id INT NOT NULL, text LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_885DBAFAA76ED395 (user_id), INDEX IDX_885DBAFA23575340 (space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, program_title VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, estimed_duration INT DEFAULT NULL, goals LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, training_id INT DEFAULT NULL, user_id INT DEFAULT NULL, comments LONGTEXT DEFAULT NULL, timestamp DATETIME NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_C42F7784BEFD98D1 (training_id), INDEX IDX_C42F7784A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spaces (id INT AUTO_INCREMENT NOT NULL, space_name VARCHAR(255) NOT NULL, theme_color VARCHAR(50) DEFAULT NULL, description LONGTEXT DEFAULT NULL, creation_date DATETIME NOT NULL, space_img LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spaces_user (spaces_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_ADDE7F5B918EABE6 (spaces_id), INDEX IDX_ADDE7F5BA76ED395 (user_id), PRIMARY KEY(spaces_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainee (id INT AUTO_INCREMENT NOT NULL, training_id INT DEFAULT NULL, skills LONGTEXT DEFAULT NULL, registration_date DATETIME NOT NULL, progress VARCHAR(255) NOT NULL, INDEX IDX_46C68DE7BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainings (id INT AUTO_INCREMENT NOT NULL, training_name VARCHAR(255) NOT NULL, duration INT DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_time DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, last_login DATETIME NOT NULL, status VARCHAR(50) NOT NULL, firstname VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE archiving ADD CONSTRAINT FK_A84564EA23575340 FOREIGN KEY (space_id) REFERENCES spaces (id)');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC167E3973CC FOREIGN KEY (chat_id_id) REFERENCES chats (id)');
        $this->addSql('ALTER TABLE chat_message ADD CONSTRAINT FK_FAB3FC169D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chats ADD CONSTRAINT FK_2D68180FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chats ADD CONSTRAINT FK_2D68180F23575340 FOREIGN KEY (space_id) REFERENCES spaces (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE contents ADD CONSTRAINT FK_B4FA1177A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contents ADD CONSTRAINT FK_B4FA117723575340 FOREIGN KEY (space_id) REFERENCES spaces (id)');
        $this->addSql('ALTER TABLE contents ADD CONSTRAINT FK_B4FA11774B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B0728823575340 FOREIGN KEY (space_id) REFERENCES spaces (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426283EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA23575340 FOREIGN KEY (space_id) REFERENCES spaces (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784BEFD98D1 FOREIGN KEY (training_id) REFERENCES trainings (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE spaces_user ADD CONSTRAINT FK_ADDE7F5B918EABE6 FOREIGN KEY (spaces_id) REFERENCES spaces (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spaces_user ADD CONSTRAINT FK_ADDE7F5BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trainee ADD CONSTRAINT FK_46C68DE7BEFD98D1 FOREIGN KEY (training_id) REFERENCES trainings (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archiving DROP FOREIGN KEY FK_A84564EA23575340');
        $this->addSql('ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC167E3973CC');
        $this->addSql('ALTER TABLE chat_message DROP FOREIGN KEY FK_FAB3FC169D86650F');
        $this->addSql('ALTER TABLE chats DROP FOREIGN KEY FK_2D68180FA76ED395');
        $this->addSql('ALTER TABLE chats DROP FOREIGN KEY FK_2D68180F23575340');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4B89032C');
        $this->addSql('ALTER TABLE contents DROP FOREIGN KEY FK_B4FA1177A76ED395');
        $this->addSql('ALTER TABLE contents DROP FOREIGN KEY FK_B4FA117723575340');
        $this->addSql('ALTER TABLE contents DROP FOREIGN KEY FK_B4FA11774B89032C');
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B0728823575340');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426283EB8070A');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAA76ED395');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA23575340');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784BEFD98D1');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784A76ED395');
        $this->addSql('ALTER TABLE spaces_user DROP FOREIGN KEY FK_ADDE7F5B918EABE6');
        $this->addSql('ALTER TABLE spaces_user DROP FOREIGN KEY FK_ADDE7F5BA76ED395');
        $this->addSql('ALTER TABLE trainee DROP FOREIGN KEY FK_46C68DE7BEFD98D1');
        $this->addSql('DROP TABLE archiving');
        $this->addSql('DROP TABLE chat_message');
        $this->addSql('DROP TABLE chats');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE contents');
        $this->addSql('DROP TABLE documents');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE spaces');
        $this->addSql('DROP TABLE spaces_user');
        $this->addSql('DROP TABLE trainee');
        $this->addSql('DROP TABLE trainings');
        $this->addSql('DROP TABLE user');
    }
}

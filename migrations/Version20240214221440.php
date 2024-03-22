<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214221440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archiving (id INT AUTO_INCREMENT NOT NULL, document_id INT DEFAULT NULL, archiving_date DATETIME NOT NULL, reason LONGTEXT DEFAULT NULL, deletion_date DATETIME DEFAULT NULL, INDEX IDX_A84564EAC33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chats (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, space_id INT DEFAULT NULL, INDEX IDX_2D68180FA76ED395 (user_id), INDEX IDX_2D68180F23575340 (space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contents (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, content_type VARCHAR(255) NOT NULL, content_link VARCHAR(255) NOT NULL, category VARCHAR(255) DEFAULT NULL, publication_date DATETIME NOT NULL, INDEX IDX_B4FA1177A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documents (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, link VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, timestamp DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, program_id INT DEFAULT NULL, module_title VARCHAR(100) NOT NULL, key_point LONGTEXT NOT NULL, duration INT DEFAULT NULL, prerequisities LONGTEXT DEFAULT NULL, INDEX IDX_C2426283EB8070A (program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, body LONGTEXT NOT NULL, state VARCHAR(255) NOT NULL, notification_type VARCHAR(255) NOT NULL, notification_date DATETIME NOT NULL, associated_link VARCHAR(255) DEFAULT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, program_title VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, estimed_duration INT DEFAULT NULL, goals LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, training_id INT DEFAULT NULL, user_id INT DEFAULT NULL, comments LONGTEXT DEFAULT NULL, timestamp DATETIME NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_C42F7784BEFD98D1 (training_id), INDEX IDX_C42F7784A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, role_name VARCHAR(255) NOT NULL, permissions LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spaces (id INT AUTO_INCREMENT NOT NULL, space_name VARCHAR(255) NOT NULL, theme_color VARCHAR(50) DEFAULT NULL, description LONGTEXT DEFAULT NULL, creation_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainee (id INT AUTO_INCREMENT NOT NULL, training_id INT DEFAULT NULL, skills LONGTEXT DEFAULT NULL, registration_date DATETIME NOT NULL, progress VARCHAR(255) NOT NULL, INDEX IDX_46C68DE7BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainings (id INT AUTO_INCREMENT NOT NULL, training_name VARCHAR(255) NOT NULL, duration INT DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_time DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, role VARCHAR(255) NOT NULL, last_login DATETIME NOT NULL, status VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_role (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, role_id INT DEFAULT NULL, INDEX IDX_2DE8C6A3A76ED395 (user_id), INDEX IDX_2DE8C6A3D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE archiving ADD CONSTRAINT FK_A84564EAC33F7837 FOREIGN KEY (document_id) REFERENCES documents (id)');
        $this->addSql('ALTER TABLE chats ADD CONSTRAINT FK_2D68180FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chats ADD CONSTRAINT FK_2D68180F23575340 FOREIGN KEY (space_id) REFERENCES spaces (id)');
        $this->addSql('ALTER TABLE contents ADD CONSTRAINT FK_B4FA1177A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426283EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784BEFD98D1 FOREIGN KEY (training_id) REFERENCES trainings (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trainee ADD CONSTRAINT FK_46C68DE7BEFD98D1 FOREIGN KEY (training_id) REFERENCES trainings (id)');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES roles (id)');
        $this->addSql('ALTER TABLE user DROP COLUMN role');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archiving DROP FOREIGN KEY FK_A84564EAC33F7837');
        $this->addSql('ALTER TABLE chats DROP FOREIGN KEY FK_2D68180FA76ED395');
        $this->addSql('ALTER TABLE chats DROP FOREIGN KEY FK_2D68180F23575340');
        $this->addSql('ALTER TABLE contents DROP FOREIGN KEY FK_B4FA1177A76ED395');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426283EB8070A');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784BEFD98D1');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784A76ED395');
        $this->addSql('ALTER TABLE trainee DROP FOREIGN KEY FK_46C68DE7BEFD98D1');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3A76ED395');
        $this->addSql('ALTER TABLE user_role DROP FOREIGN KEY FK_2DE8C6A3D60322AC');
        $this->addSql('DROP TABLE archiving');
        $this->addSql('DROP TABLE chats');
        $this->addSql('DROP TABLE contents');
        $this->addSql('DROP TABLE documents');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE spaces');
        $this->addSql('DROP TABLE trainee');
        $this->addSql('DROP TABLE trainings');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_role');
    }
}

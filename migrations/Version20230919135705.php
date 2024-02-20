<?php

declare(strict_types=1);


namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230919135705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE archivings (id INT AUTO_INCREMENT NOT NULL, document_id_id INT NOT NULL, archiving_date DATETIME NOT NULL, reason LONGTEXT DEFAULT NULL, deletion_date DATETIME DEFAULT NULL, INDEX IDX_5B79810916E5E825 (document_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chats (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, spacer_id_id INT NOT NULL, INDEX IDX_2D68180F9D86650F (user_id_id), INDEX IDX_2D68180F2AAAA902 (spacer_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contents (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, content_type VARCHAR(255) NOT NULL, content_link VARCHAR(255) NOT NULL, category VARCHAR(100) DEFAULT NULL, publication_date DATETIME NOT NULL, INDEX IDX_B4FA11779D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documents (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, link VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, timestamp DATETIME NOT NULL, format VARCHAR(50) DEFAULT NULL, size INT DEFAULT NULL, INDEX IDX_A2B072889D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modules (id INT AUTO_INCREMENT NOT NULL, program_id_id INT NOT NULL, module_title VARCHAR(255) NOT NULL, key_point LONGTEXT NOT NULL, duration INT DEFAULT NULL, prerequisites LONGTEXT DEFAULT NULL, INDEX IDX_2EB743D7E12DEDA1 (program_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notifications (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, body LONGTEXT DEFAULT NULL, state VARCHAR(50) NOT NULL, notification_type VARCHAR(100) NOT NULL, notification_date DATETIME NOT NULL, associated_link VARCHAR(255) DEFAULT NULL, INDEX IDX_6000B0D39D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programs (id INT AUTO_INCREMENT NOT NULL, training_id_id INT NOT NULL, program_title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, estimed_duration INT DEFAULT NULL, goals LONGTEXT DEFAULT NULL, INDEX IDX_F1496545909E143A (training_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reports (id INT AUTO_INCREMENT NOT NULL, training_id_id INT NOT NULL, user_id_id INT NOT NULL, comments LONGTEXT DEFAULT NULL, timestamp DATETIME NOT NULL, type VARCHAR(100) NOT NULL, INDEX IDX_F11FA745909E143A (training_id_id), INDEX IDX_F11FA7459D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, role_name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, permissions LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spaces (id INT AUTO_INCREMENT NOT NULL, space_name VARCHAR(255) NOT NULL, theme_color VARCHAR(50) DEFAULT NULL, description LONGTEXT DEFAULT NULL, creation_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainees (id INT AUTO_INCREMENT NOT NULL, training_id_id INT NOT NULL, skills LONGTEXT DEFAULT NULL, registration_date DATETIME NOT NULL, progress VARCHAR(50) NOT NULL, INDEX IDX_25267E5D909E143A (training_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainers (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(15) DEFAULT NULL, skills LONGTEXT DEFAULT NULL, join_date DATETIME NOT NULL, specialization VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainings (id INT AUTO_INCREMENT NOT NULL, training_name VARCHAR(255) NOT NULL, duration INT DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, role VARCHAR(255) NOT NULL, last_login DATETIME NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_roles (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, role_id_id INT DEFAULT NULL, INDEX IDX_54FCD59F9D86650F (user_id_id), INDEX IDX_54FCD59F88987678 (role_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE archivings ADD CONSTRAINT FK_5B79810916E5E825 FOREIGN KEY (document_id_id) REFERENCES documents (id)');
        $this->addSql('ALTER TABLE chats ADD CONSTRAINT FK_2D68180F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chats ADD CONSTRAINT FK_2D68180F2AAAA902 FOREIGN KEY (spacer_id_id) REFERENCES spaces (id)');
        $this->addSql('ALTER TABLE contents ADD CONSTRAINT FK_B4FA11779D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B072889D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE modules ADD CONSTRAINT FK_2EB743D7E12DEDA1 FOREIGN KEY (program_id_id) REFERENCES programs (id)');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D39D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE programs ADD CONSTRAINT FK_F1496545909E143A FOREIGN KEY (training_id_id) REFERENCES trainings (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA745909E143A FOREIGN KEY (training_id_id) REFERENCES trainings (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA7459D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trainees ADD CONSTRAINT FK_25267E5D909E143A FOREIGN KEY (training_id_id) REFERENCES trainings (id)');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_roles ADD CONSTRAINT FK_54FCD59F88987678 FOREIGN KEY (role_id_id) REFERENCES roles (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archivings DROP FOREIGN KEY FK_5B79810916E5E825');
        $this->addSql('ALTER TABLE chats DROP FOREIGN KEY FK_2D68180F9D86650F');
        $this->addSql('ALTER TABLE chats DROP FOREIGN KEY FK_2D68180F2AAAA902');
        $this->addSql('ALTER TABLE contents DROP FOREIGN KEY FK_B4FA11779D86650F');
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B072889D86650F');
        $this->addSql('ALTER TABLE modules DROP FOREIGN KEY FK_2EB743D7E12DEDA1');
        $this->addSql('ALTER TABLE notifications DROP FOREIGN KEY FK_6000B0D39D86650F');
        $this->addSql('ALTER TABLE programs DROP FOREIGN KEY FK_F1496545909E143A');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA745909E143A');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA7459D86650F');
        $this->addSql('ALTER TABLE trainees DROP FOREIGN KEY FK_25267E5D909E143A');
        $this->addSql('ALTER TABLE user_roles DROP FOREIGN KEY FK_54FCD59F9D86650F');
        $this->addSql('ALTER TABLE user_roles DROP FOREIGN KEY FK_54FCD59F88987678');
        $this->addSql('DROP TABLE archivings');
        $this->addSql('DROP TABLE chats');
        $this->addSql('DROP TABLE contents');
        $this->addSql('DROP TABLE documents');
        $this->addSql('DROP TABLE modules');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE programs');
        $this->addSql('DROP TABLE reports');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE spaces');
        $this->addSql('DROP TABLE trainees');
        $this->addSql('DROP TABLE trainers');
        $this->addSql('DROP TABLE trainings');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_roles');
    }
}

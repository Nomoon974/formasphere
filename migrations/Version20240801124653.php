<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801124653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784BEFD98D1');
        $this->addSql('ALTER TABLE trainee DROP FOREIGN KEY FK_46C68DE7BEFD98D1');
        $this->addSql('DROP TABLE trainee');
        $this->addSql('DROP TABLE trainings');
        $this->addSql('DROP INDEX IDX_C42F7784BEFD98D1 ON report');
        $this->addSql('ALTER TABLE report DROP training_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trainee (id INT AUTO_INCREMENT NOT NULL, training_id INT DEFAULT NULL, skills LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, registration_date DATETIME NOT NULL, progress VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_46C68DE7BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE trainings (id INT AUTO_INCREMENT NOT NULL, training_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, duration INT DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_time DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE trainee ADD CONSTRAINT FK_46C68DE7BEFD98D1 FOREIGN KEY (training_id) REFERENCES trainings (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE report ADD training_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784BEFD98D1 FOREIGN KEY (training_id) REFERENCES trainings (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C42F7784BEFD98D1 ON report (training_id)');
    }
}

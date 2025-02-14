<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801124137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426283EB8070A');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP INDEX IDX_C2426283EB8070A ON module');
        $this->addSql('ALTER TABLE module DROP program_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, program_title VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, estimed_duration INT DEFAULT NULL, goals LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE module ADD program_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426283EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C2426283EB8070A ON module (program_id)');
    }
}

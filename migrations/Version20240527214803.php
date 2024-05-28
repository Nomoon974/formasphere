<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527214803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_5F9E962A76ED395');
//        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_5F9E962A4B89032C');
//        $this->addSql('DROP INDEX IDX_5F9E962A4B89032C ON comment');
//        $this->addSql('DROP INDEX IDX_5F9E962A76ED395 ON comment');
//        $this->addSql('ALTER TABLE comment ADD user_id_id INT NOT NULL, DROP user_id, DROP posts_id');
//        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
//        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
//        $this->addSql('CREATE INDEX IDX_9474526C9D86650F ON comment (user_id_id)');
//        $this->addSql('CREATE INDEX IDX_9474526C4B89032C ON comment (post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9D86650F');
//        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4B89032C');
//        $this->addSql('DROP INDEX IDX_9474526C9D86650F ON comment');
//        $this->addSql('DROP INDEX IDX_9474526C4B89032C ON comment');
//        $this->addSql('ALTER TABLE comment ADD posts_id INT NOT NULL, CHANGE user_id_id user_id INT NOT NULL');
//        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_5F9E962A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
//        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_5F9E962A4B89032C FOREIGN KEY (posts_id) REFERENCES posts (id) ON UPDATE NO ACTION ON DELETE CASCADE');
//        $this->addSql('CREATE INDEX IDX_5F9E962A4B89032C ON comment (posts_id)');
//        $this->addSql('CREATE INDEX IDX_5F9E962A76ED395 ON comment (user_id)');
    }
}

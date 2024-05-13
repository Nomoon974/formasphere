<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513145431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9487CA85');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9D86650F');
        $this->addSql('DROP INDEX IDX_9474526C9487CA85 ON comment');
        $this->addSql('DROP INDEX IDX_9474526C9D86650F ON comment');
        $this->addSql('ALTER TABLE comment ADD user_id_id INT NOT NULL, ADD posts_id INT NOT NULL, DROP user_id, DROP content_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9474526CD5E258C5 ON comment (posts_id)');
        $this->addSql('CREATE INDEX IDX_9474526C9D86650F ON comment (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CD5E258C5');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9D86650F');
        $this->addSql('DROP INDEX IDX_9474526CD5E258C5 ON comment');
        $this->addSql('DROP INDEX IDX_9474526C9D86650F ON comment');
        $this->addSql('ALTER TABLE comment ADD user_id INT NOT NULL, ADD content_id INT NOT NULL, DROP user_id_id, DROP posts_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9487CA85 FOREIGN KEY (content_id) REFERENCES contents (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9474526C9487CA85 ON comment (content_id)');
        $this->addSql('CREATE INDEX IDX_9474526C9D86650F ON comment (user_id)');
    }
}

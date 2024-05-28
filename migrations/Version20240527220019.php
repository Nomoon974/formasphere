<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527220019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // Add column `comment_id` to `posts` table
        $this->addSql('ALTER TABLE posts ADD comment_id INT DEFAULT NULL');

        // Add the foreign key constraint
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_5A8A6C8DF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) ON DELETE SET NULL');

        // Create an index for the `comment_id` column
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF8697D13 ON posts (comment_id)');
    }

    public function down(Schema $schema) : void
    {
        // Drop the foreign key constraint
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_5A8A6C8DF8697D13');

        // Drop the index for the `comment_id` column
        $this->addSql('DROP INDEX IDX_5A8A6C8DF8697D13 ON posts');

        // Drop the `comment_id` column
        $this->addSql('ALTER TABLE posts DROP comment_id');
    }
}

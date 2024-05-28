<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527211820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
//        $this->addSql('ALTER TABLE comment ADD post_id INT NOT NULL');
//
//        // Add the foreign key constraint
//        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_5F9E962A4B89032C FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE');
//
//        // Create an index for the `post_id` column
//        $this->addSql('CREATE INDEX IDX_5F9E962A4B89032C ON comment (post_id)');
    }

    public function down(Schema $schema) : void
    {
        // Drop the foreign key constraint
//        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_5F9E962A4B89032C');
//
//        // Drop the index for the `post_id` column
//        $this->addSql('DROP INDEX IDX_5F9E962A4B89032C ON comment');
//
//        // Drop the `post_id` column
//        $this->addSql('ALTER TABLE comment DROP post_id');
    }
}

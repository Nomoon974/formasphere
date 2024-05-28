<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527213512 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add foreign keys to the comment table';
    }

    public function up(Schema $schema) : void
    {
        // Add the foreign key constraint for `posts_id`
//        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_5F9E962A4B89032C FOREIGN KEY (posts_id) REFERENCES posts (id) ON DELETE CASCADE');
//
//        // Add the foreign key constraint for `user_id`
//        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_5F9E962A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
//
//        // Create indexes for better performance
//        $this->addSql('CREATE INDEX IDX_5F9E962A4B89032C ON comment (posts_id)');
//        $this->addSql('CREATE INDEX IDX_5F9E962A76ED395 ON comment (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // Drop the foreign key constraint for `posts_id`
//        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_5F9E962A4B89032C');
//
//        // Drop the foreign key constraint for `user_id`
//        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_5F9E962A76ED395');
//
//        // Drop indexes
//        $this->addSql('DROP INDEX IDX_5F9E962A4B89032C ON comment');
//        $this->addSql('DROP INDEX IDX_5F9E962A76ED395 ON comment');
    }
}

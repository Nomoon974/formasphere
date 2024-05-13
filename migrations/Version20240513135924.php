<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513135924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Renommer les colonnes dans la table `comments`
        $this->addSql('ALTER TABLE comment RENAME COLUMN user_id_id TO user_id');
        $this->addSql('ALTER TABLE comment RENAME COLUMN content_id_id TO content_id');
    }

    public function down(Schema $schema): void
    {
        // Recréer la table `documents` si nécessaire
        // $this->addSql('CREATE TABLE documents ...');

        // Revenir aux noms de colonnes originaux dans `comments`
        $this->addSql('ALTER TABLE comment RENAME COLUMN user_id TO user_id_id');
        $this->addSql('ALTER TABLE comment RENAME COLUMN content_id TO content_id_id');
    }
}

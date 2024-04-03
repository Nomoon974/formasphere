<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240403133139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Supprime la table user_role';
    }

    public function up(Schema $schema): void
    {
        // Supprime la table user_role
        $this->addSql('DROP TABLE IF EXISTS user_role');
    }

    public function down(Schema $schema): void
    {
        // Ici, tu peux ajouter le code SQL pour recréer la table user_role
        // ou laisser un commentaire si tu ne prévois pas de rollback.
    }
}

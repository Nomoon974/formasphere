<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801101308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spaces ADD module_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE spaces ADD CONSTRAINT FK_DD2B6478AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_DD2B6478AFC2B591 ON spaces (module_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spaces DROP FOREIGN KEY FK_DD2B6478AFC2B591');
        $this->addSql('DROP INDEX IDX_DD2B6478AFC2B591 ON spaces');
        $this->addSql('ALTER TABLE spaces DROP module_id');
    }
}

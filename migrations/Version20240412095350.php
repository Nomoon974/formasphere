<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412095350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archiving DROP FOREIGN KEY FK_A84564EAC33F7837');
        $this->addSql('DROP INDEX IDX_A84564EAC33F7837 ON archiving');
        $this->addSql('ALTER TABLE archiving CHANGE document_id space_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE archiving ADD CONSTRAINT FK_A84564EA23575340 FOREIGN KEY (space_id) REFERENCES spaces (id)');
        $this->addSql('CREATE INDEX IDX_A84564EA23575340 ON archiving (space_id)');
        $this->addSql('ALTER TABLE contents ADD space_id INT NOT NULL');
        $this->addSql('ALTER TABLE contents ADD CONSTRAINT FK_B4FA117723575340 FOREIGN KEY (space_id) REFERENCES spaces (id)');
        $this->addSql('CREATE INDEX IDX_B4FA117723575340 ON contents (space_id)');
        $this->addSql('ALTER TABLE documents ADD space_id INT NOT NULL');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B0728823575340 FOREIGN KEY (space_id) REFERENCES spaces (id)');
        $this->addSql('CREATE INDEX IDX_A2B0728823575340 ON documents (space_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B0728823575340');
        $this->addSql('DROP INDEX IDX_A2B0728823575340 ON documents');
        $this->addSql('ALTER TABLE documents DROP space_id');
        $this->addSql('ALTER TABLE contents DROP FOREIGN KEY FK_B4FA117723575340');
        $this->addSql('DROP INDEX IDX_B4FA117723575340 ON contents');
        $this->addSql('ALTER TABLE contents DROP space_id');
        $this->addSql('ALTER TABLE archiving DROP FOREIGN KEY FK_A84564EA23575340');
        $this->addSql('DROP INDEX IDX_A84564EA23575340 ON archiving');
        $this->addSql('ALTER TABLE archiving CHANGE space_id document_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE archiving ADD CONSTRAINT FK_A84564EAC33F7837 FOREIGN KEY (document_id) REFERENCES documents (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A84564EAC33F7837 ON archiving (document_id)');
    }
}

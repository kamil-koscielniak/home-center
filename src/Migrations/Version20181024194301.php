<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181024194301 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE shopping_list DROP CONSTRAINT fk_3dc1a4599d86650f');
        $this->addSql('DROP INDEX idx_3dc1a4599d86650f');
        $this->addSql('ALTER TABLE shopping_list RENAME COLUMN user_id_id TO user_id');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT FK_3DC1A459A76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3DC1A459A76ED395 ON shopping_list (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE shopping_list DROP CONSTRAINT FK_3DC1A459A76ED395');
        $this->addSql('DROP INDEX IDX_3DC1A459A76ED395');
        $this->addSql('ALTER TABLE shopping_list RENAME COLUMN user_id TO user_id_id');
        $this->addSql('ALTER TABLE shopping_list ADD CONSTRAINT fk_3dc1a4599d86650f FOREIGN KEY (user_id_id) REFERENCES app_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_3dc1a4599d86650f ON shopping_list (user_id_id)');
    }
}

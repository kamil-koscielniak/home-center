<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181030200112 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE shopping_category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shop_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shopping_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE shopping_category (id INT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE shop (id INT NOT NULL, name VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE shopping_item (id INT NOT NULL, shopping_list_id INT NOT NULL, shop_id INT DEFAULT NULL, shopping_category_id INT DEFAULT NULL, creator_id INT NOT NULL, picker_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6612795F23245BF9 ON shopping_item (shopping_list_id)');
        $this->addSql('CREATE INDEX IDX_6612795F4D16C4DD ON shopping_item (shop_id)');
        $this->addSql('CREATE INDEX IDX_6612795F9051A6C4 ON shopping_item (shopping_category_id)');
        $this->addSql('CREATE INDEX IDX_6612795F61220EA6 ON shopping_item (creator_id)');
        $this->addSql('CREATE INDEX IDX_6612795F8874902 ON shopping_item (picker_id)');
        $this->addSql('ALTER TABLE shopping_item ADD CONSTRAINT FK_6612795F23245BF9 FOREIGN KEY (shopping_list_id) REFERENCES shopping_list (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping_item ADD CONSTRAINT FK_6612795F4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping_item ADD CONSTRAINT FK_6612795F9051A6C4 FOREIGN KEY (shopping_category_id) REFERENCES shopping_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping_item ADD CONSTRAINT FK_6612795F61220EA6 FOREIGN KEY (creator_id) REFERENCES app_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopping_item ADD CONSTRAINT FK_6612795F8874902 FOREIGN KEY (picker_id) REFERENCES app_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE shopping_item DROP CONSTRAINT FK_6612795F9051A6C4');
        $this->addSql('ALTER TABLE shopping_item DROP CONSTRAINT FK_6612795F4D16C4DD');
        $this->addSql('DROP SEQUENCE shopping_category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shop_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shopping_item_id_seq CASCADE');
        $this->addSql('DROP TABLE shopping_category');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE shopping_item');
    }
}

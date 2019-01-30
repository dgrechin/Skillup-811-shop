<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190130180856 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, created_at DATETIME NOT NULL, status INT NOT NULL, is_paid TINYINT(1) DEFAULT \'0\' NOT NULL, amount INT DEFAULT 0 NOT NULL, INDEX IDX_E52FFDEEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY FK_62809DB0A76ED395');
        $this->addSql('DROP INDEX IDX_62809DB0A76ED395 ON order_items');
        $this->addSql('ALTER TABLE order_items ADD product_id INT NOT NULL, ADD quantity INT NOT NULL, ADD price INT NOT NULL, ADD cost INT NOT NULL, DROP user_id, DROP created_at, DROP is_paid, DROP amount, CHANGE status order_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_62809DB08D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_62809DB04584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('CREATE INDEX IDX_62809DB08D9F6D38 ON order_items (order_id)');
        $this->addSql('CREATE INDEX IDX_62809DB04584665A ON order_items (product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY FK_62809DB08D9F6D38');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, order_id INT NOT NULL, quantity INT NOT NULL, price INT NOT NULL, cost INT NOT NULL, INDEX IDX_52EA1F094584665A (product_id), INDEX IDX_52EA1F098D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('DROP TABLE orders');
        $this->addSql('ALTER TABLE order_items DROP FOREIGN KEY FK_62809DB04584665A');
        $this->addSql('DROP INDEX IDX_62809DB08D9F6D38 ON order_items');
        $this->addSql('DROP INDEX IDX_62809DB04584665A ON order_items');
        $this->addSql('ALTER TABLE order_items ADD user_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD status INT NOT NULL, ADD is_paid TINYINT(1) DEFAULT \'0\' NOT NULL, ADD amount INT DEFAULT 0 NOT NULL, DROP order_id, DROP product_id, DROP quantity, DROP price, DROP cost');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_62809DB0A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_62809DB0A76ED395 ON order_items (user_id)');
    }
}

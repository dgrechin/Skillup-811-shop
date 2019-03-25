<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190320184007 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE product_attribute');
        $this->addSql('ALTER TABLE categories ADD lft INT NOT NULL DEFAULT 0, ADD lvl INT NOT NULL DEFAULT 0, ADD rgt INT NOT NULL DEFAULT 0');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product_attribute (product_id INT NOT NULL, attribute_id INT NOT NULL, INDEX IDX_94DA5976B6E62EFA (attribute_id), INDEX IDX_94DA59764584665A (product_id), PRIMARY KEY(product_id, attribute_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA59764584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA5976B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attributes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories DROP lft, DROP lvl, DROP rgt');
    }
}

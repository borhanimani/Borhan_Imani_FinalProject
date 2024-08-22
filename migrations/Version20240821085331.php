<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240821085331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE puchase_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE purchase_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE purchase (id INT NOT NULL, userid_id INT NOT NULL, productid_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6117D13B58E0A285 ON purchase (userid_id)');
        $this->addSql('CREATE INDEX IDX_6117D13BAF89CCED ON purchase (productid_id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B58E0A285 FOREIGN KEY (userid_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BAF89CCED FOREIGN KEY (productid_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE puchase DROP CONSTRAINT fk_7a345fa358e0a285');
        $this->addSql('ALTER TABLE puchase DROP CONSTRAINT fk_7a345fa3af89cced');
        $this->addSql('DROP TABLE puchase');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE purchase_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE puchase_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE puchase (id INT NOT NULL, userid_id INT NOT NULL, productid_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_7a345fa3af89cced ON puchase (productid_id)');
        $this->addSql('CREATE INDEX idx_7a345fa358e0a285 ON puchase (userid_id)');
        $this->addSql('ALTER TABLE puchase ADD CONSTRAINT fk_7a345fa358e0a285 FOREIGN KEY (userid_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE puchase ADD CONSTRAINT fk_7a345fa3af89cced FOREIGN KEY (productid_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE purchase DROP CONSTRAINT FK_6117D13B58E0A285');
        $this->addSql('ALTER TABLE purchase DROP CONSTRAINT FK_6117D13BAF89CCED');
        $this->addSql('DROP TABLE purchase');
    }
}

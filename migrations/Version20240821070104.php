<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240821070104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE buy_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE puchase_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE puchase (id INT NOT NULL, userid_id INT NOT NULL, productid_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7A345FA358E0A285 ON puchase (userid_id)');
        $this->addSql('CREATE INDEX IDX_7A345FA3AF89CCED ON puchase (productid_id)');
        $this->addSql('ALTER TABLE puchase ADD CONSTRAINT FK_7A345FA358E0A285 FOREIGN KEY (userid_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE puchase ADD CONSTRAINT FK_7A345FA3AF89CCED FOREIGN KEY (productid_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE puchase_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE buy_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE puchase DROP CONSTRAINT FK_7A345FA358E0A285');
        $this->addSql('ALTER TABLE puchase DROP CONSTRAINT FK_7A345FA3AF89CCED');
        $this->addSql('DROP TABLE puchase');
        $this->addSql('ALTER TABLE "user" DROP name');
    }
}

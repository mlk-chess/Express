<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220320142333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE place_category DROP CONSTRAINT fk_2c17fe4212469de2');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT fk_42c8495553c674ee');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT fk_42c84955da6a219');
        $this->addSql('ALTER TABLE place_category DROP CONSTRAINT fk_2c17fe42da6a219');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT fk_42c8495544972a0e');
        $this->addSql('ALTER TABLE ligne DROP CONSTRAINT fk_57f0db837c26c5e6');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE place_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reservation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE victim_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_train_id_seq CASCADE');
        $this->addSql('DROP TABLE ligne');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE place_category');
        $this->addSql('DROP TABLE victim');
        $this->addSql('DROP TABLE ligne_train');
        $this->addSql('ALTER TABLE "user" ADD status SMALLINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE place_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reservation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE victim_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_train_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ligne (id INT NOT NULL, ligne_train_id INT DEFAULT NULL, longitude_gare_d VARCHAR(255) NOT NULL, latitude_gare_d VARCHAR(255) NOT NULL, longitude_gare_a VARCHAR(255) NOT NULL, latitude_gare_a VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_57f0db837c26c5e6 ON ligne (ligne_train_id)');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reservation (id INT NOT NULL, victim_id INT DEFAULT NULL, place_id INT DEFAULT NULL, offer_id INT DEFAULT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_42c84955da6a219 ON reservation (place_id)');
        $this->addSql('CREATE INDEX idx_42c8495544972a0e ON reservation (victim_id)');
        $this->addSql('CREATE INDEX idx_42c8495553c674ee ON reservation (offer_id)');
        $this->addSql('CREATE TABLE offer (id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE place (id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, cp VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE place_category (place_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(place_id, category_id))');
        $this->addSql('CREATE INDEX idx_2c17fe4212469de2 ON place_category (category_id)');
        $this->addSql('CREATE INDEX idx_2c17fe42da6a219 ON place_category (place_id)');
        $this->addSql('CREATE TABLE victim (id INT NOT NULL, firstname VARCHAR(100) DEFAULT NULL, lastname VARCHAR(100) DEFAULT NULL, age INT DEFAULT NULL, weigth INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ligne_train (id INT NOT NULL, horaire_a TIME(0) WITHOUT TIME ZONE NOT NULL, horaire_d TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE ligne ADD CONSTRAINT fk_57f0db837c26c5e6 FOREIGN KEY (ligne_train_id) REFERENCES ligne_train (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk_42c8495544972a0e FOREIGN KEY (victim_id) REFERENCES victim (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk_42c84955da6a219 FOREIGN KEY (place_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT fk_42c8495553c674ee FOREIGN KEY (offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE place_category ADD CONSTRAINT fk_2c17fe42da6a219 FOREIGN KEY (place_id) REFERENCES place (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE place_category ADD CONSTRAINT fk_2c17fe4212469de2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" DROP status');
    }
}

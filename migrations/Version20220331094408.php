<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220331094408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE line_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE line_train_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE option_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE train_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE wagon_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE line (id INT NOT NULL, longitude_departure VARCHAR(255) NOT NULL, latitude_departure VARCHAR(255) NOT NULL, longitude_arrival VARCHAR(255) NOT NULL, latitude_arrival VARCHAR(255) NOT NULL, name_station_departure VARCHAR(255) NOT NULL, name_station_arrival VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE line_train (id INT NOT NULL, train_id INT DEFAULT NULL, line_id INT DEFAULT NULL, date_departure DATE NOT NULL, date_arrival DATE NOT NULL, time_departure TIME(0) WITHOUT TIME ZONE NOT NULL, time_arrival TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A3E2C32023BCD4D0 ON line_train (train_id)');
        $this->addSql('CREATE INDEX IDX_A3E2C3204D7B7542 ON line_train (line_id)');
        $this->addSql('CREATE TABLE option (id INT NOT NULL, wagon_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description TEXT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5A8600B0A21C43DD ON option (wagon_id)');
        $this->addSql('CREATE INDEX IDX_5A8600B07E3C61F9 ON option (owner_id)');
        $this->addSql('CREATE TABLE train (id INT NOT NULL, owner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5C66E4A37E3C61F9 ON train (owner_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, company_name VARCHAR(50) DEFAULT NULL, address VARCHAR(180) DEFAULT NULL, city VARCHAR(180) DEFAULT NULL, zip_code CHAR(5) DEFAULT NULL, phone_number CHAR(10) DEFAULT NULL, status SMALLINT NOT NULL, token VARCHAR(255) DEFAULT NULL, siret BIGINT DEFAULT NULL, siren INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE wagon (id INT NOT NULL, train_id INT DEFAULT NULL, owner_id INT DEFAULT NULL, class VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, place_nb INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BBDBD3623BCD4D0 ON wagon (train_id)');
        $this->addSql('CREATE INDEX IDX_BBDBD367E3C61F9 ON wagon (owner_id)');
        $this->addSql('ALTER TABLE line_train ADD CONSTRAINT FK_A3E2C32023BCD4D0 FOREIGN KEY (train_id) REFERENCES train (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE line_train ADD CONSTRAINT FK_A3E2C3204D7B7542 FOREIGN KEY (line_id) REFERENCES line (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE option ADD CONSTRAINT FK_5A8600B0A21C43DD FOREIGN KEY (wagon_id) REFERENCES wagon (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE option ADD CONSTRAINT FK_5A8600B07E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE train ADD CONSTRAINT FK_5C66E4A37E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wagon ADD CONSTRAINT FK_BBDBD3623BCD4D0 FOREIGN KEY (train_id) REFERENCES train (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wagon ADD CONSTRAINT FK_BBDBD367E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE line_train DROP CONSTRAINT FK_A3E2C3204D7B7542');
        $this->addSql('ALTER TABLE line_train DROP CONSTRAINT FK_A3E2C32023BCD4D0');
        $this->addSql('ALTER TABLE wagon DROP CONSTRAINT FK_BBDBD3623BCD4D0');
        $this->addSql('ALTER TABLE option DROP CONSTRAINT FK_5A8600B07E3C61F9');
        $this->addSql('ALTER TABLE train DROP CONSTRAINT FK_5C66E4A37E3C61F9');
        $this->addSql('ALTER TABLE wagon DROP CONSTRAINT FK_BBDBD367E3C61F9');
        $this->addSql('ALTER TABLE option DROP CONSTRAINT FK_5A8600B0A21C43DD');
        $this->addSql('DROP SEQUENCE line_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE line_train_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE option_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE train_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE wagon_id_seq CASCADE');
        $this->addSql('DROP TABLE line');
        $this->addSql('DROP TABLE line_train');
        $this->addSql('DROP TABLE option');
        $this->addSql('DROP TABLE train');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE wagon');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220416032751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE booking_seat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE booking_seat (id INT NOT NULL, booking_id INT NOT NULL, seat_id INT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_25CD14283301C60 ON booking_seat (booking_id)');
        $this->addSql('CREATE INDEX IDX_25CD1428C1DAFE35 ON booking_seat (seat_id)');
        $this->addSql('ALTER TABLE booking_seat ADD CONSTRAINT FK_25CD14283301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking_seat ADD CONSTRAINT FK_25CD1428C1DAFE35 FOREIGN KEY (seat_id) REFERENCES seat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE booking_seat_id_seq CASCADE');
        $this->addSql('DROP TABLE booking_seat');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208155302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE place_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reservation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE victim_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_train_id_seq CASCADE');
        $this->addSql('ALTER TABLE line_train ADD date_departure DATE NOT NULL');
        $this->addSql('ALTER TABLE line_train ADD date_arrival DATE NOT NULL');
        $this->addSql('ALTER TABLE line_train ADD time_departure TIME(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE line_train ADD time_arrival TIME(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE place_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reservation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE victim_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_train_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE line_train DROP date_departure');
        $this->addSql('ALTER TABLE line_train DROP date_arrival');
        $this->addSql('ALTER TABLE line_train DROP time_departure');
        $this->addSql('ALTER TABLE line_train DROP time_arrival');
    }
}

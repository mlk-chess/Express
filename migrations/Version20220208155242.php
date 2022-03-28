<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208155242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line_train ADD date_departure DATE NOT NULL');
        $this->addSql('ALTER TABLE line_train ADD date_arrival DATE NOT NULL');
        $this->addSql('ALTER TABLE line_train ADD time_departure TIME(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE line_train ADD time_arrival TIME(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE line_train DROP date_departure');
        $this->addSql('ALTER TABLE line_train DROP date_arrival');
        $this->addSql('ALTER TABLE line_train DROP time_departure');
        $this->addSql('ALTER TABLE line_train DROP time_arrival');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230901105628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eth ADD price NUMERIC(10, 2) NOT NULL, DROP price_today, DROP price_one_day_before, DROP price_two_days_before, DROP price_three_days_before, DROP price_four_days_before, DROP price_five_days_before, DROP price_six_days_before');
        $this->addSql('ALTER TABLE verify_email CHANGE token token VARCHAR(1500) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eth ADD price_one_day_before NUMERIC(10, 2) NOT NULL, ADD price_two_days_before NUMERIC(10, 2) NOT NULL, ADD price_three_days_before NUMERIC(10, 2) NOT NULL, ADD price_four_days_before NUMERIC(10, 2) NOT NULL, ADD price_five_days_before NUMERIC(10, 2) NOT NULL, ADD price_six_days_before NUMERIC(10, 2) NOT NULL, CHANGE price price_today NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE verify_email CHANGE token token VARCHAR(255) NOT NULL');
    }
}

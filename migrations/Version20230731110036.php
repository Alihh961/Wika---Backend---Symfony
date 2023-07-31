<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230731110036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audio ADD name VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL, ADD url VARCHAR(255) NOT NULL, ADD size INT NOT NULL, ADD format VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE image ADD name VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL, ADD url VARCHAR(255) NOT NULL, ADD size INT NOT NULL, ADD format VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE video ADD name VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL, ADD url VARCHAR(255) NOT NULL, ADD size INT NOT NULL, ADD format VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audio DROP name, DROP description, DROP url, DROP size, DROP format');
        $this->addSql('ALTER TABLE image DROP name, DROP description, DROP url, DROP size, DROP format');
        $this->addSql('ALTER TABLE video DROP name, DROP description, DROP url, DROP size, DROP format');
    }
}

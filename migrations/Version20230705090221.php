<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705090221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction_nft (transaction_id INT NOT NULL, nft_id INT NOT NULL, INDEX IDX_2283F3F52FC0CB0F (transaction_id), INDEX IDX_2283F3F5E813668D (nft_id), PRIMARY KEY(transaction_id, nft_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction_nft ADD CONSTRAINT FK_2283F3F52FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction_nft ADD CONSTRAINT FK_2283F3F5E813668D FOREIGN KEY (nft_id) REFERENCES nft (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction_nft DROP FOREIGN KEY FK_2283F3F52FC0CB0F');
        $this->addSql('ALTER TABLE transaction_nft DROP FOREIGN KEY FK_2283F3F5E813668D');
        $this->addSql('DROP TABLE transaction_nft');
    }
}

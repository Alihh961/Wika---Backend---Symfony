<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706065115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_nft DROP FOREIGN KEY FK_32D127B7A76ED395');
        $this->addSql('ALTER TABLE user_nft DROP FOREIGN KEY FK_32D127B7E813668D');
        $this->addSql('DROP TABLE user_nft');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F5B7AF75');
        $this->addSql('DROP INDEX IDX_8D93D649F5B7AF75 ON user');
        $this->addSql('ALTER TABLE user DROP address_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_nft (user_id INT NOT NULL, nft_id INT NOT NULL, INDEX IDX_32D127B7A76ED395 (user_id), INDEX IDX_32D127B7E813668D (nft_id), PRIMARY KEY(user_id, nft_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_nft ADD CONSTRAINT FK_32D127B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_nft ADD CONSTRAINT FK_32D127B7E813668D FOREIGN KEY (nft_id) REFERENCES nft (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD address_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649F5B7AF75 ON user (address_id)');
    }
}

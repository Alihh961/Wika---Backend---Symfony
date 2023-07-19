<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705085400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, municipality VARCHAR(35) NOT NULL, department VARCHAR(35) NOT NULL, region VARCHAR(35) NOT NULL, path VARCHAR(70) NOT NULL, building_number VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE audio (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, size INT NOT NULL, format VARCHAR(255) NOT NULL, duration INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eth (id INT AUTO_INCREMENT NOT NULL, price_today NUMERIC(10, 2) NOT NULL, price_one_day_before NUMERIC(10, 2) NOT NULL, price_two_days_before NUMERIC(10, 2) NOT NULL, price_three_days_before NUMERIC(10, 2) NOT NULL, price_four_days_before NUMERIC(10, 2) NOT NULL, price_five_days_before NUMERIC(10, 2) NOT NULL, price_six_days_before NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, size INT NOT NULL, format VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, size INT NOT NULL, format VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nft (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, video_id INT DEFAULT NULL, audio_id INT DEFAULT NULL, price_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, quantity_available INT NOT NULL, INDEX IDX_D9C7463C3DA5256D (image_id), INDEX IDX_D9C7463C29C1004E (video_id), INDEX IDX_D9C7463C3A3123C7 (audio_id), INDEX IDX_D9C7463CD614C7E7 (price_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nft_sub_category (nft_id INT NOT NULL, sub_category_id INT NOT NULL, INDEX IDX_8FB34E85E813668D (nft_id), INDEX IDX_8FB34E85F7BFE87C (sub_category_id), PRIMARY KEY(nft_id, sub_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_category (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_BCE3F79812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, issue_date DATETIME NOT NULL, total_price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, address_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, gender VARCHAR(10) NOT NULL, date_of_birth DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649F5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_nft (user_id INT NOT NULL, nft_id INT NOT NULL, INDEX IDX_32D127B7A76ED395 (user_id), INDEX IDX_32D127B7E813668D (nft_id), PRIMARY KEY(user_id, nft_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, size INT NOT NULL, format VARCHAR(255) NOT NULL, duration INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463C3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463C29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463C3A3123C7 FOREIGN KEY (audio_id) REFERENCES audio (id)');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463CD614C7E7 FOREIGN KEY (price_id) REFERENCES eth (id)');
        $this->addSql('ALTER TABLE nft_sub_category ADD CONSTRAINT FK_8FB34E85E813668D FOREIGN KEY (nft_id) REFERENCES nft (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nft_sub_category ADD CONSTRAINT FK_8FB34E85F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE user_nft ADD CONSTRAINT FK_32D127B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_nft ADD CONSTRAINT FK_32D127B7E813668D FOREIGN KEY (nft_id) REFERENCES nft (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463C3DA5256D');
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463C29C1004E');
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463C3A3123C7');
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463CD614C7E7');
        $this->addSql('ALTER TABLE nft_sub_category DROP FOREIGN KEY FK_8FB34E85E813668D');
        $this->addSql('ALTER TABLE nft_sub_category DROP FOREIGN KEY FK_8FB34E85F7BFE87C');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79812469DE2');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F5B7AF75');
        $this->addSql('ALTER TABLE user_nft DROP FOREIGN KEY FK_32D127B7A76ED395');
        $this->addSql('ALTER TABLE user_nft DROP FOREIGN KEY FK_32D127B7E813668D');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE audio');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE eth');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE nft');
        $this->addSql('DROP TABLE nft_sub_category');
        $this->addSql('DROP TABLE sub_category');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_nft');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

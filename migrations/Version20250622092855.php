<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250622092855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE glace (id INT AUTO_INCREMENT NOT NULL, pate_id INT NOT NULL, nom VARCHAR(255) NOT NULL, secret_ingredient VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A6DD185F2B068EB6 (pate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE glace_ingredient (glace_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_5EB128937BD89A2B (glace_id), INDEX IDX_5EB12893933FE08C (ingredient_id), PRIMARY KEY(glace_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pate (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE glace ADD CONSTRAINT FK_A6DD185F2B068EB6 FOREIGN KEY (pate_id) REFERENCES pate (id)');
        $this->addSql('ALTER TABLE glace_ingredient ADD CONSTRAINT FK_5EB128937BD89A2B FOREIGN KEY (glace_id) REFERENCES glace (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE glace_ingredient ADD CONSTRAINT FK_5EB12893933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE glace DROP FOREIGN KEY FK_A6DD185F2B068EB6');
        $this->addSql('ALTER TABLE glace_ingredient DROP FOREIGN KEY FK_5EB128937BD89A2B');
        $this->addSql('ALTER TABLE glace_ingredient DROP FOREIGN KEY FK_5EB12893933FE08C');
        $this->addSql('DROP TABLE glace');
        $this->addSql('DROP TABLE glace_ingredient');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE pate');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

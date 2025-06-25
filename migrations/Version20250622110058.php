<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250622110058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE glace DROP FOREIGN KEY FK_A6DD185F2B068EB6');
        $this->addSql('CREATE TABLE cornet (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE glace_topping (glace_id INT NOT NULL, topping_id INT NOT NULL, INDEX IDX_7C12239E7BD89A2B (glace_id), INDEX IDX_7C12239EE9C2067C (topping_id), PRIMARY KEY(glace_id, topping_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topping (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE glace_topping ADD CONSTRAINT FK_7C12239E7BD89A2B FOREIGN KEY (glace_id) REFERENCES glace (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE glace_topping ADD CONSTRAINT FK_7C12239EE9C2067C FOREIGN KEY (topping_id) REFERENCES topping (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE glace_ingredient DROP FOREIGN KEY FK_5EB12893933FE08C');
        $this->addSql('ALTER TABLE glace_ingredient DROP FOREIGN KEY FK_5EB128937BD89A2B');
        $this->addSql('DROP TABLE glace_ingredient');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE pate');
        $this->addSql('DROP INDEX IDX_A6DD185F2B068EB6 ON glace');
        $this->addSql('ALTER TABLE glace CHANGE pate_id cornet_id INT NOT NULL');
        $this->addSql('ALTER TABLE glace ADD CONSTRAINT FK_A6DD185FEFAA6724 FOREIGN KEY (cornet_id) REFERENCES cornet (id)');
        $this->addSql('CREATE INDEX IDX_A6DD185FEFAA6724 ON glace (cornet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE glace DROP FOREIGN KEY FK_A6DD185FEFAA6724');
        $this->addSql('CREATE TABLE glace_ingredient (glace_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_5EB12893933FE08C (ingredient_id), INDEX IDX_5EB128937BD89A2B (glace_id), PRIMARY KEY(glace_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pate (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE glace_ingredient ADD CONSTRAINT FK_5EB12893933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE glace_ingredient ADD CONSTRAINT FK_5EB128937BD89A2B FOREIGN KEY (glace_id) REFERENCES glace (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE glace_topping DROP FOREIGN KEY FK_7C12239E7BD89A2B');
        $this->addSql('ALTER TABLE glace_topping DROP FOREIGN KEY FK_7C12239EE9C2067C');
        $this->addSql('DROP TABLE cornet');
        $this->addSql('DROP TABLE glace_topping');
        $this->addSql('DROP TABLE topping');
        $this->addSql('DROP INDEX IDX_A6DD185FEFAA6724 ON glace');
        $this->addSql('ALTER TABLE glace CHANGE cornet_id pate_id INT NOT NULL');
        $this->addSql('ALTER TABLE glace ADD CONSTRAINT FK_A6DD185F2B068EB6 FOREIGN KEY (pate_id) REFERENCES pate (id)');
        $this->addSql('CREATE INDEX IDX_A6DD185F2B068EB6 ON glace (pate_id)');
    }
}

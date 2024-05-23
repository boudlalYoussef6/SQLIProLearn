<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240523164200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, course_id INT NOT NULL, user_id INT NOT NULL, status VARCHAR(50) NOT NULL, date_sent DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_validation DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A45BDDC1591CC992 (course_id), INDEX IDX_A45BDDC1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id_id INT DEFAULT NULL, label VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_64C19C1B3750AF4 (parent_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, label VARCHAR(200) NOT NULL, description LONGTEXT DEFAULT NULL, id_gene INT DEFAULT NULL, INDEX IDX_169E6FB912469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, course_id INT NOT NULL, title VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_2D737AEF591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, connected_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', username VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visit (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, course_id INT NOT NULL, nbr_visit INT NOT NULL, last_time_visit DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_437EE939A76ED395 (user_id), INDEX IDX_437EE939591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1B3750AF4 FOREIGN KEY (parent_id_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1591CC992');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1A76ED395');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1B3750AF4');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB912469DE2');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF591CC992');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939A76ED395');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939591CC992');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE visit');
    }
}

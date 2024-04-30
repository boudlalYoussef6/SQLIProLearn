<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425100304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, cours_id INT NOT NULL, user_id INT NOT NULL, status VARCHAR(50) NOT NULL, date_sent DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_validation DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A45BDDC17ECF78B0 (cours_id), INDEX IDX_A45BDDC1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC17ECF78B0 FOREIGN KEY (cours_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('DROP TABLE request');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE93996EF99BF');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE9399D86650F');
        $this->addSql('DROP INDEX IDX_437EE9399D86650F ON visit');
        $this->addSql('DROP INDEX IDX_437EE93996EF99BF ON visit');
        $this->addSql('ALTER TABLE visit ADD user_id INT NOT NULL, ADD course_id INT NOT NULL, DROP user_id_id, DROP course_id_id');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_437EE939A76ED395 ON visit (user_id)');
        $this->addSql('CREATE INDEX IDX_437EE939591CC992 ON visit (course_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC17ECF78B0');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1A76ED395');
        $this->addSql('DROP TABLE application');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939A76ED395');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939591CC992');
        $this->addSql('DROP INDEX IDX_437EE939A76ED395 ON visit');
        $this->addSql('DROP INDEX IDX_437EE939591CC992 ON visit');
        $this->addSql('ALTER TABLE visit ADD user_id_id INT NOT NULL, ADD course_id_id INT NOT NULL, DROP user_id, DROP course_id');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE93996EF99BF FOREIGN KEY (course_id_id) REFERENCES course (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE9399D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_437EE9399D86650F ON visit (user_id_id)');
        $this->addSql('CREATE INDEX IDX_437EE93996EF99BF ON visit (course_id_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210604134120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rubrique (id INT AUTO_INCREMENT NOT NULL, typeprojet_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_8FA4097CE3FEE0EE (typeprojet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE typeprojet (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rubrique ADD CONSTRAINT FK_8FA4097CE3FEE0EE FOREIGN KEY (typeprojet_id) REFERENCES typeprojet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rubrique DROP FOREIGN KEY FK_8FA4097CE3FEE0EE');
        $this->addSql('DROP TABLE rubrique');
        $this->addSql('DROP TABLE typeprojet');
    }
}

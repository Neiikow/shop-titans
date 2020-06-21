<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200621190653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE furniture_upgrade (id INT AUTO_INCREMENT NOT NULL, furniture_id INT DEFAULT NULL, lvl INT NOT NULL, size VARCHAR(255) NOT NULL, gold_cost INT DEFAULT NULL, gem_cost INT DEFAULT NULL, time INT DEFAULT NULL, description VARCHAR(255) NOT NULL, effects LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', prerequisite VARCHAR(255) DEFAULT NULL, account_lvl INT NOT NULL, INDEX IDX_328681ECCF5485C3 (furniture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE furniture_upgrade ADD CONSTRAINT FK_328681ECCF5485C3 FOREIGN KEY (furniture_id) REFERENCES furniture (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE furniture_upgrade');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617134127 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE achievement (id INT AUTO_INCREMENT NOT NULL, prev_tier_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, img VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, tier INT NOT NULL, gem_reward INT NOT NULL, UNIQUE INDEX UNIQ_96737FF1FF981E0A (prev_tier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achievement ADD CONSTRAINT FK_96737FF1FF981E0A FOREIGN KEY (prev_tier_id) REFERENCES achievement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE achievement DROP FOREIGN KEY FK_96737FF1FF981E0A');
        $this->addSql('DROP TABLE achievement');
    }
}

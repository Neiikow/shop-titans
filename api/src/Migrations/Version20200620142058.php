<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200620142058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE champion (id INT AUTO_INCREMENT NOT NULL, leader_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, coin_cost INT DEFAULT NULL, hp INT NOT NULL, atk INT NOT NULL, def INT NOT NULL, eva INT NOT NULL, crit_rate INT NOT NULL, crit_dmg INT NOT NULL, threat INT NOT NULL, prerequisite VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_45437EB473154ED4 (leader_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE champion ADD CONSTRAINT FK_45437EB473154ED4 FOREIGN KEY (leader_id) REFERENCES `character` (id)');
        $this->addSql('ALTER TABLE skill ADD champion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477FA7FD7EB FOREIGN KEY (champion_id) REFERENCES champion (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE477FA7FD7EB ON skill (champion_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477FA7FD7EB');
        $this->addSql('DROP TABLE champion');
        $this->addSql('DROP INDEX IDX_5E3DE477FA7FD7EB ON skill');
        $this->addSql('ALTER TABLE skill DROP champion_id');
    }
}

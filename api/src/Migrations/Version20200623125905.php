<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200623125905 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE champion_rank (id INT AUTO_INCREMENT NOT NULL, skill_unlock_id INT DEFAULT NULL, champion_id INT DEFAULT NULL, rank INT NOT NULL, coin_cost INT DEFAULT NULL, hp_increase INT DEFAULT NULL, atk_increase INT DEFAULT NULL, def_increase INT DEFAULT NULL, UNIQUE INDEX UNIQ_4429695CD4ACE143 (skill_unlock_id), INDEX IDX_4429695CFA7FD7EB (champion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE champion_rank ADD CONSTRAINT FK_4429695CD4ACE143 FOREIGN KEY (skill_unlock_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE champion_rank ADD CONSTRAINT FK_4429695CFA7FD7EB FOREIGN KEY (champion_id) REFERENCES champion (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE champion_rank');
    }
}

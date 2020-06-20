<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200620132328 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE quest (id INT AUTO_INCREMENT NOT NULL, area_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, difficulty VARCHAR(255) NOT NULL, is_boss TINYINT(1) NOT NULL, power_required INT NOT NULL, xp INT NOT NULL, quest_time INT NOT NULL, rest_time INT NOT NULL, heal_time INT NOT NULL, item_min INT NOT NULL, item_max INT NOT NULL, monster_hp INT NOT NULL, monster_base_dmg INT NOT NULL, monster_aoe_dmg INT NOT NULL, INDEX IDX_4317F817BD0F409C (area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817BD0F409C FOREIGN KEY (area_id) REFERENCES quest_area (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE quest');
    }
}

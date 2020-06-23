<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200623123749 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hero (id INT AUTO_INCREMENT NOT NULL, class VARCHAR(255) NOT NULL, sub_class VARCHAR(255) NOT NULL, img VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, skill_slot_lvl LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', gold_cost INT DEFAULT NULL, gem_cost INT DEFAULT NULL, prerequisite VARCHAR(255) DEFAULT NULL, crit_rate INT NOT NULL, crit_dmg INT NOT NULL, threat INT NOT NULL, hp INT NOT NULL, atk INT NOT NULL, def INT NOT NULL, eva INT NOT NULL, element VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE hero');
    }
}

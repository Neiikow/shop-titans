<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200618162956 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE guild_upgrade (id INT AUTO_INCREMENT NOT NULL, perk_id INT DEFAULT NULL, boost_id INT DEFAULT NULL, lvl INT NOT NULL, prerequisite VARCHAR(255) NOT NULL, renowm_cost INT NOT NULL, effect VARCHAR(255) DEFAULT NULL, INDEX IDX_87DCBA85DF084E33 (perk_id), INDEX IDX_87DCBA85B09F48DA (boost_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE guild_upgrade ADD CONSTRAINT FK_87DCBA85DF084E33 FOREIGN KEY (perk_id) REFERENCES guild_perk (id)');
        $this->addSql('ALTER TABLE guild_upgrade ADD CONSTRAINT FK_87DCBA85B09F48DA FOREIGN KEY (boost_id) REFERENCES guild_boost (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE guild_upgrade');
    }
}

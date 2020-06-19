<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200619053133 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE chest (id INT AUTO_INCREMENT NOT NULL, open_key_id INT DEFAULT NULL, area_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, img VARCHAR(255) DEFAULT NULL, open_cost INT NOT NULL, gold_value INT NOT NULL, UNIQUE INDEX UNIQ_FB44B3B7E43C4D26 (open_key_id), UNIQUE INDEX UNIQ_FB44B3B7BD0F409C (area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chest ADD CONSTRAINT FK_FB44B3B7E43C4D26 FOREIGN KEY (open_key_id) REFERENCES consumable (id)');
        $this->addSql('ALTER TABLE chest ADD CONSTRAINT FK_FB44B3B7BD0F409C FOREIGN KEY (area_id) REFERENCES quest_area (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE chest');
    }
}

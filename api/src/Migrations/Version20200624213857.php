<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200624213857 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE quest_key (id INT AUTO_INCREMENT NOT NULL, quest_id INT DEFAULT NULL, key_drop_id INT DEFAULT NULL, rate INT NOT NULL, UNIQUE INDEX UNIQ_5BB46BA1209E9EF4 (quest_id), UNIQUE INDEX UNIQ_5BB46BA12FF4635E (key_drop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quest_key ADD CONSTRAINT FK_5BB46BA1209E9EF4 FOREIGN KEY (quest_id) REFERENCES quest (id)');
        $this->addSql('ALTER TABLE quest_key ADD CONSTRAINT FK_5BB46BA12FF4635E FOREIGN KEY (key_drop_id) REFERENCES consumable (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE quest_key');
    }
}

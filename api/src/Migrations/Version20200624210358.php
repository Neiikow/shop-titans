<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200624210358 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE quest_component (id INT AUTO_INCREMENT NOT NULL, component_id INT DEFAULT NULL, quest_id INT DEFAULT NULL, min INT NOT NULL, max INT NOT NULL, INDEX IDX_EFA3AC8FE2ABAFFF (component_id), INDEX IDX_EFA3AC8F209E9EF4 (quest_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quest_component ADD CONSTRAINT FK_EFA3AC8FE2ABAFFF FOREIGN KEY (component_id) REFERENCES component (id)');
        $this->addSql('ALTER TABLE quest_component ADD CONSTRAINT FK_EFA3AC8F209E9EF4 FOREIGN KEY (quest_id) REFERENCES quest (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE quest_component');
    }
}

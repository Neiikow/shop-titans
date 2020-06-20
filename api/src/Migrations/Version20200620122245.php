<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200620122245 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE worker (id INT AUTO_INCREMENT NOT NULL, artisan_id INT DEFAULT NULL, pack_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, job VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_9FB2BF625ED3C7B7 (artisan_id), UNIQUE INDEX UNIQ_9FB2BF621919B217 (pack_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE worker ADD CONSTRAINT FK_9FB2BF625ED3C7B7 FOREIGN KEY (artisan_id) REFERENCES `character` (id)');
        $this->addSql('ALTER TABLE worker ADD CONSTRAINT FK_9FB2BF621919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE worker');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210625125032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announce ADD introduction VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C6F5DA3DE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C6F5DA3DE FOREIGN KEY (announce_id) REFERENCES announce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F6F5DA3DE');
        $this->addSql('ALTER TABLE image CHANGE announce_id announce_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F6F5DA3DE FOREIGN KEY (announce_id) REFERENCES announce (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announce DROP introduction');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C6F5DA3DE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C6F5DA3DE FOREIGN KEY (announce_id) REFERENCES announce (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F6F5DA3DE');
        $this->addSql('ALTER TABLE image CHANGE announce_id announce_id INT NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F6F5DA3DE FOREIGN KEY (announce_id) REFERENCES announce (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}

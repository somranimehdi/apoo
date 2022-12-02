<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221202140216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_stories (user_id INT NOT NULL, stories_id INT NOT NULL, INDEX IDX_C4868355A76ED395 (user_id), INDEX IDX_C4868355BF2402DE (stories_id), PRIMARY KEY(user_id, stories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_stories ADD CONSTRAINT FK_C4868355A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_stories ADD CONSTRAINT FK_C4868355BF2402DE FOREIGN KEY (stories_id) REFERENCES stories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE suggestions ADD CONSTRAINT FK_91B686149D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_91B686149D86650F ON suggestions (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_stories DROP FOREIGN KEY FK_C4868355A76ED395');
        $this->addSql('ALTER TABLE user_stories DROP FOREIGN KEY FK_C4868355BF2402DE');
        $this->addSql('DROP TABLE user_stories');
        $this->addSql('ALTER TABLE suggestions DROP FOREIGN KEY FK_91B686149D86650F');
        $this->addSql('DROP INDEX IDX_91B686149D86650F ON suggestions');
    }
}

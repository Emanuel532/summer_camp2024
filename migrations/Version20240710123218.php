<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710123218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_account DROP FOREIGN KEY FK_253B48AE9D86650F');
        $this->addSql('DROP INDEX UNIQ_253B48AE9D86650F ON user_account');
        $this->addSql('ALTER TABLE user_account DROP user_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_account ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_account ADD CONSTRAINT FK_253B48AE9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_253B48AE9D86650F ON user_account (user_id_id)');
    }
}

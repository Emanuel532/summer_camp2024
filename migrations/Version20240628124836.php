<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628124836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workout_user DROP FOREIGN KEY FK_F51DD535A6CCCFC9');
        $this->addSql('ALTER TABLE workout_user DROP FOREIGN KEY FK_F51DD535A76ED395');
        $this->addSql('DROP TABLE workout_user');
        $this->addSql('ALTER TABLE exercise_log ADD exercise_id INT NOT NULL');
        $this->addSql('ALTER TABLE exercitii CHANGE link_video link_video VARCHAR(2049) DEFAULT NULL');
        $this->addSql('ALTER TABLE workout ADD user_id INT NOT NULL, ADD date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB72A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_649FFB72A76ED395 ON workout (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workout_user (workout_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F51DD535A6CCCFC9 (workout_id), INDEX IDX_F51DD535A76ED395 (user_id), PRIMARY KEY(workout_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE workout_user ADD CONSTRAINT FK_F51DD535A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workout_user ADD CONSTRAINT FK_F51DD535A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_log DROP exercise_id');
        $this->addSql('ALTER TABLE exercitii CHANGE link_video link_video VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB72A76ED395');
        $this->addSql('DROP INDEX IDX_649FFB72A76ED395 ON workout');
        $this->addSql('ALTER TABLE workout DROP user_id, DROP date');
    }
}

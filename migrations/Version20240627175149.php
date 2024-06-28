<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627175149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercise_log (id INT AUTO_INCREMENT NOT NULL, workout_id_id INT NOT NULL, nr_reps INT NOT NULL, durata INT NOT NULL, INDEX IDX_1960CDB9268F2D43 (workout_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercitii (id INT AUTO_INCREMENT NOT NULL, tip_id_id INT DEFAULT NULL, nume VARCHAR(255) NOT NULL, link_video VARCHAR(255) NOT NULL, INDEX IDX_5B39E9622C343EA4 (tip_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tip (id INT AUTO_INCREMENT NOT NULL, nume VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nume VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, parola VARCHAR(255) NOT NULL, birthday DATE NOT NULL, gender TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workout (id INT AUTO_INCREMENT NOT NULL, tip_id_id INT NOT NULL, nume VARCHAR(255) NOT NULL, INDEX IDX_649FFB722C343EA4 (tip_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workout_user (workout_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F51DD535A6CCCFC9 (workout_id), INDEX IDX_F51DD535A76ED395 (user_id), PRIMARY KEY(workout_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercise_log ADD CONSTRAINT FK_1960CDB9268F2D43 FOREIGN KEY (workout_id_id) REFERENCES workout (id)');
        $this->addSql('ALTER TABLE exercitii ADD CONSTRAINT FK_5B39E9622C343EA4 FOREIGN KEY (tip_id_id) REFERENCES tip (id)');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB722C343EA4 FOREIGN KEY (tip_id_id) REFERENCES tip (id)');
        $this->addSql('ALTER TABLE workout_user ADD CONSTRAINT FK_F51DD535A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workout_user ADD CONSTRAINT FK_F51DD535A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise_log DROP FOREIGN KEY FK_1960CDB9268F2D43');
        $this->addSql('ALTER TABLE exercitii DROP FOREIGN KEY FK_5B39E9622C343EA4');
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB722C343EA4');
        $this->addSql('ALTER TABLE workout_user DROP FOREIGN KEY FK_F51DD535A6CCCFC9');
        $this->addSql('ALTER TABLE workout_user DROP FOREIGN KEY FK_F51DD535A76ED395');
        $this->addSql('DROP TABLE exercise_log');
        $this->addSql('DROP TABLE exercitii');
        $this->addSql('DROP TABLE tip');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE workout');
        $this->addSql('DROP TABLE workout_user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

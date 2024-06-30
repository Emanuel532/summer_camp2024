<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628135239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise_log DROP FOREIGN KEY FK_1960CDB9268F2D43');
        $this->addSql('DROP INDEX IDX_1960CDB9268F2D43 ON exercise_log');
        $this->addSql('ALTER TABLE exercise_log ADD workout_id INT NOT NULL, ADD duration TIME DEFAULT NULL, DROP workout_id_id, DROP durata');
        $this->addSql('ALTER TABLE exercise_log ADD CONSTRAINT FK_1960CDB9A6CCCFC9 FOREIGN KEY (workout_id) REFERENCES workout (id)');
        $this->addSql('ALTER TABLE exercise_log ADD CONSTRAINT FK_1960CDB9E934951A FOREIGN KEY (exercise_id) REFERENCES exercitii (id)');
        $this->addSql('CREATE INDEX IDX_1960CDB9A6CCCFC9 ON exercise_log (workout_id)');
        $this->addSql('CREATE INDEX IDX_1960CDB9E934951A ON exercise_log (exercise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise_log DROP FOREIGN KEY FK_1960CDB9A6CCCFC9');
        $this->addSql('ALTER TABLE exercise_log DROP FOREIGN KEY FK_1960CDB9E934951A');
        $this->addSql('DROP INDEX IDX_1960CDB9A6CCCFC9 ON exercise_log');
        $this->addSql('DROP INDEX IDX_1960CDB9E934951A ON exercise_log');
        $this->addSql('ALTER TABLE exercise_log ADD durata INT NOT NULL, DROP duration, CHANGE workout_id workout_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE exercise_log ADD CONSTRAINT FK_1960CDB9268F2D43 FOREIGN KEY (workout_id_id) REFERENCES workout (id)');
        $this->addSql('CREATE INDEX IDX_1960CDB9268F2D43 ON exercise_log (workout_id_id)');
    }
}

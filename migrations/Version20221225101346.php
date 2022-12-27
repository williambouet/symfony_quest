<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221225101346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE watchlist (user_id INT NOT NULL, program_id INT NOT NULL, INDEX IDX_340388D3A76ED395 (user_id), INDEX IDX_340388D33EB8070A (program_id), PRIMARY KEY(user_id, program_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE watchlist ADD CONSTRAINT FK_340388D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE watchlist ADD CONSTRAINT FK_340388D33EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_user DROP FOREIGN KEY FK_8075834E3EB8070A');
        $this->addSql('ALTER TABLE program_user DROP FOREIGN KEY FK_8075834EA76ED395');
        $this->addSql('DROP TABLE program_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE program_user (program_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8075834EA76ED395 (user_id), INDEX IDX_8075834E3EB8070A (program_id), PRIMARY KEY(program_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE program_user ADD CONSTRAINT FK_8075834E3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_user ADD CONSTRAINT FK_8075834EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE watchlist DROP FOREIGN KEY FK_340388D3A76ED395');
        $this->addSql('ALTER TABLE watchlist DROP FOREIGN KEY FK_340388D33EB8070A');
        $this->addSql('DROP TABLE watchlist');
    }
}

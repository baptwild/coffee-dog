<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250713093318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE booking DROP INDEX UNIQ_E00CEDDEBC999F9F, ADD INDEX IDX_E00CEDDEBC999F9F (rate_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking CHANGE rate_id rate_id INT DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE booking DROP INDEX IDX_E00CEDDEBC999F9F, ADD UNIQUE INDEX UNIQ_E00CEDDEBC999F9F (rate_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking CHANGE rate_id rate_id INT NOT NULL
        SQL);
    }
}

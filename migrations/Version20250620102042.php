<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250620102042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, rate NUMERIC(10, 2) NOT NULL, rate_type VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD user_id INT NOT NULL, ADD dog_id INT NOT NULL, ADD rate_id INT NOT NULL, ADD arrival_datetime DATETIME NOT NULL, ADD departure_datetime DATETIME NOT NULL, DROP daily_rate, DROP start_date, DROP end_date, CHANGE effective_date effective_date DATETIME NOT NULL, CHANGE is_active is_active TINYINT(1) NOT NULL, CHANGE status status VARCHAR(255) NOT NULL, CHANGE total_cost total_cost NUMERIC(10, 2) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE634DFEB FOREIGN KEY (dog_id) REFERENCES dog (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEBC999F9F FOREIGN KEY (rate_id) REFERENCES rate (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E00CEDDEA76ED395 ON booking (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E00CEDDE634DFEB ON booking (dog_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_E00CEDDEBC999F9F ON booking (rate_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE dog ADD owner_id INT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE breed breed VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE dog ADD CONSTRAINT FK_812C397D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_812C397D7E3C61F9 ON dog (owner_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notification ADD user_id INT NOT NULL, CHANGE message message LONGTEXT NOT NULL, CHANGE type type VARCHAR(255) NOT NULL, CHANGE sent_at sent_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', CHANGE is_read is_read TINYINT(1) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_BF5476CAA76ED395 ON notification (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD address VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD zip_code INT NOT NULL, ADD complementary_address VARCHAR(255) NOT NULL, DROP name, DROP role, CHANGE phone_number phone_number VARCHAR(20) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEBC999F9F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE rate
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE634DFEB
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_E00CEDDEA76ED395 ON booking
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_E00CEDDE634DFEB ON booking
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_E00CEDDEBC999F9F ON booking
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD daily_rate NUMERIC(10, 2) DEFAULT NULL, ADD start_date DATETIME DEFAULT NULL, ADD end_date DATETIME DEFAULT NULL, DROP user_id, DROP dog_id, DROP rate_id, DROP arrival_datetime, DROP departure_datetime, CHANGE effective_date effective_date DATETIME DEFAULT NULL, CHANGE is_active is_active TINYINT(1) DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE total_cost total_cost NUMERIC(10, 2) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE dog DROP FOREIGN KEY FK_812C397D7E3C61F9
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_812C397D7E3C61F9 ON dog
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE dog DROP owner_id, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE breed breed VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_BF5476CAA76ED395 ON notification
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notification DROP user_id, CHANGE message message LONGTEXT DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE sent_at sent_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', CHANGE is_read is_read TINYINT(1) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD name VARCHAR(255) NOT NULL, ADD role VARCHAR(255) NOT NULL, DROP first_name, DROP last_name, DROP address, DROP city, DROP zip_code, DROP complementary_address, CHANGE phone_number phone_number VARCHAR(15) NOT NULL
        SQL);
    }
}

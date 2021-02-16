<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210216173017 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account_transactions (id INT AUTO_INCREMENT NOT NULL, type INT NOT NULL, date_created INT NOT NULL, sum DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sweeptakes_accounts (id INT AUTO_INCREMENT NOT NULL, type SMALLINT NOT NULL, spent DOUBLE PRECISION NOT NULL, `left` DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sweeptakes_gifts (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_available TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_prizes (id INT AUTO_INCREMENT NOT NULL, type SMALLINT NOT NULL, object_id INT NOT NULL, user_id INT NOT NULL, date_won INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE account_transactions');
        $this->addSql('DROP TABLE sweeptakes_accounts');
        $this->addSql('DROP TABLE sweeptakes_gifts');
        $this->addSql('DROP TABLE user_prizes');
    }
}

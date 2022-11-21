<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221121165810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds the fist friendly FedImg host';
    }

    public function up(Schema $schema): void
    {
        // $this->addSql('INSERT INTO host_org ("name", "nick", "url") VALUES ("WaxLuna Games", "waxluna", "fedimg.waxlunagames.com")');
        $this->addSql('INSERT INTO host_org (name, nick, url) VALUES ("WaxLuna Games", "waxluna", "fedimg.waxlunagames.com")');
        // this up() migration is auto-generated, please modify it to your needs
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}

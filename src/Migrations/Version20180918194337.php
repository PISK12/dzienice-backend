<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180918194337 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE district (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_city_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_31C154875531CBDF ON district (id_city_id)');
        $this->addSql('CREATE TABLE city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE street (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, name_in_genitive VARCHAR(255) NOT NULL, short_name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE street_district (street_id INTEGER NOT NULL, district_id INTEGER NOT NULL, PRIMARY KEY(street_id, district_id))');
        $this->addSql('CREATE INDEX IDX_7E41476A87CF8EB ON street_district (street_id)');
        $this->addSql('CREATE INDEX IDX_7E41476AB08FA272 ON street_district (district_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE district');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE street');
        $this->addSql('DROP TABLE street_district');
    }
}

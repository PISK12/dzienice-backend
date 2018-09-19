<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180918195215 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_7E41476AB08FA272');
        $this->addSql('DROP INDEX IDX_7E41476A87CF8EB');
        $this->addSql('CREATE TEMPORARY TABLE __temp__street_district AS SELECT street_id, district_id FROM street_district');
        $this->addSql('DROP TABLE street_district');
        $this->addSql('CREATE TABLE street_district (street_id INTEGER NOT NULL, district_id INTEGER NOT NULL, PRIMARY KEY(street_id, district_id), CONSTRAINT FK_7E41476A87CF8EB FOREIGN KEY (street_id) REFERENCES street (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7E41476AB08FA272 FOREIGN KEY (district_id) REFERENCES district (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO street_district (street_id, district_id) SELECT street_id, district_id FROM __temp__street_district');
        $this->addSql('DROP TABLE __temp__street_district');
        $this->addSql('CREATE INDEX IDX_7E41476AB08FA272 ON street_district (district_id)');
        $this->addSql('CREATE INDEX IDX_7E41476A87CF8EB ON street_district (street_id)');
        $this->addSql('DROP INDEX IDX_31C154875531CBDF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__district AS SELECT id, id_city_id, name FROM district');
        $this->addSql('DROP TABLE district');
        $this->addSql('CREATE TABLE district (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_31C154878BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO district (id, city_id, name) SELECT id, id_city_id, name FROM __temp__district');
        $this->addSql('DROP TABLE __temp__district');
        $this->addSql('CREATE INDEX IDX_31C154878BAC62AF ON district (city_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_31C154878BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__district AS SELECT id, city_id, name FROM district');
        $this->addSql('DROP TABLE district');
        $this->addSql('CREATE TABLE district (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, id_city_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO district (id, id_city_id, name) SELECT id, city_id, name FROM __temp__district');
        $this->addSql('DROP TABLE __temp__district');
        $this->addSql('CREATE INDEX IDX_31C154875531CBDF ON district (id_city_id)');
        $this->addSql('DROP INDEX IDX_7E41476A87CF8EB');
        $this->addSql('DROP INDEX IDX_7E41476AB08FA272');
        $this->addSql('CREATE TEMPORARY TABLE __temp__street_district AS SELECT street_id, district_id FROM street_district');
        $this->addSql('DROP TABLE street_district');
        $this->addSql('CREATE TABLE street_district (street_id INTEGER NOT NULL, district_id INTEGER NOT NULL, PRIMARY KEY(street_id, district_id))');
        $this->addSql('INSERT INTO street_district (street_id, district_id) SELECT street_id, district_id FROM __temp__street_district');
        $this->addSql('DROP TABLE __temp__street_district');
        $this->addSql('CREATE INDEX IDX_7E41476A87CF8EB ON street_district (street_id)');
        $this->addSql('CREATE INDEX IDX_7E41476AB08FA272 ON street_district (district_id)');
    }
}

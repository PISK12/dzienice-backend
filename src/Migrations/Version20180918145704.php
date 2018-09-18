<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180918145704 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_31C154875531CBDF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__district AS SELECT id, id_city_id, name FROM district');
        $this->addSql('DROP TABLE district');
        $this->addSql('CREATE TABLE district (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_city_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_31C154875531CBDF FOREIGN KEY (id_city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO district (id, id_city_id, name) SELECT id, id_city_id, name FROM __temp__district');
        $this->addSql('DROP TABLE __temp__district');
        $this->addSql('CREATE INDEX IDX_31C154875531CBDF ON district (id_city_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__street AS SELECT id, name, name_in_genitive, short_name FROM street');
        $this->addSql('DROP TABLE street');
        $this->addSql('CREATE TABLE street (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, districts_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, name_in_genitive VARCHAR(255) NOT NULL COLLATE BINARY, short_name VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_F0EED3D859CA2297 FOREIGN KEY (districts_id) REFERENCES district (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO street (id, name, name_in_genitive, short_name) SELECT id, name, name_in_genitive, short_name FROM __temp__street');
        $this->addSql('DROP TABLE __temp__street');
        $this->addSql('CREATE INDEX IDX_F0EED3D859CA2297 ON street (districts_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_31C154875531CBDF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__district AS SELECT id, id_city_id, name FROM district');
        $this->addSql('DROP TABLE district');
        $this->addSql('CREATE TABLE district (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_city_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO district (id, id_city_id, name) SELECT id, id_city_id, name FROM __temp__district');
        $this->addSql('DROP TABLE __temp__district');
        $this->addSql('CREATE INDEX IDX_31C154875531CBDF ON district (id_city_id)');
        $this->addSql('DROP INDEX IDX_F0EED3D859CA2297');
        $this->addSql('CREATE TEMPORARY TABLE __temp__street AS SELECT id, name, name_in_genitive, short_name FROM street');
        $this->addSql('DROP TABLE street');
        $this->addSql('CREATE TABLE street (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, name_in_genitive VARCHAR(255) NOT NULL, short_name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO street (id, name, name_in_genitive, short_name) SELECT id, name, name_in_genitive, short_name FROM __temp__street');
        $this->addSql('DROP TABLE __temp__street');
    }
}

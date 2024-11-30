<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241130011822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ALTER id TYPE INT');
        $this->addSql('ALTER TABLE game ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE tile_type ADD description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE tile_type ADD country TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE tile_type ADD detailed_description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE tile_type DROP special_ability');
        $this->addSql('ALTER TABLE tile_type DROP set_of_tiles');
        $this->addSql('ALTER TABLE tile_type DROP rarity');
        $this->addSql('ALTER TABLE tile_type ALTER id TYPE BIGINT');
        $this->addSql('ALTER TABLE tile_type ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE tile_type ALTER category TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE turn ALTER id TYPE INT');
        $this->addSql('ALTER TABLE turn ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE game ALTER id TYPE BIGINT');
        $this->addSql('CREATE SEQUENCE game_id_seq');
        $this->addSql('SELECT setval(\'game_id_seq\', (SELECT MAX(id) FROM game))');
        $this->addSql('ALTER TABLE game ALTER id SET DEFAULT nextval(\'game_id_seq\')');
        $this->addSql('ALTER TABLE tile_type ADD special_ability VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tile_type ADD set_of_tiles INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tile_type ADD rarity VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE tile_type DROP description');
        $this->addSql('ALTER TABLE tile_type DROP country');
        $this->addSql('ALTER TABLE tile_type DROP detailed_description');
        $this->addSql('ALTER TABLE tile_type ALTER id TYPE INT');
        $this->addSql('CREATE SEQUENCE tile_type_id_seq');
        $this->addSql('SELECT setval(\'tile_type_id_seq\', (SELECT MAX(id) FROM tile_type))');
        $this->addSql('ALTER TABLE tile_type ALTER id SET DEFAULT nextval(\'tile_type_id_seq\')');
        $this->addSql('ALTER TABLE tile_type ALTER category TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE turn ALTER id TYPE BIGINT');
        $this->addSql('CREATE SEQUENCE turn_id_seq');
        $this->addSql('SELECT setval(\'turn_id_seq\', (SELECT MAX(id) FROM turn))');
        $this->addSql('ALTER TABLE turn ALTER id SET DEFAULT nextval(\'turn_id_seq\')');
    }
}

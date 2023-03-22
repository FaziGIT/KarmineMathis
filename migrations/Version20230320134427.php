<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320134427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_jeu_jeu (categorie_jeu_id INT NOT NULL, jeu_id INT NOT NULL, INDEX IDX_6AE9D872AB89317 (categorie_jeu_id), INDEX IDX_6AE9D8728C9E392E (jeu_id), PRIMARY KEY(categorie_jeu_id, jeu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_jeu_jeu ADD CONSTRAINT FK_6AE9D872AB89317 FOREIGN KEY (categorie_jeu_id) REFERENCES categorie_jeu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_jeu_jeu ADD CONSTRAINT FK_6AE9D8728C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jeu_categorie_jeu DROP FOREIGN KEY FK_2C5D38018C9E392E');
        $this->addSql('ALTER TABLE jeu_categorie_jeu DROP FOREIGN KEY FK_2C5D3801AB89317');
        $this->addSql('DROP TABLE jeu_categorie_jeu');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jeu_categorie_jeu (jeu_id INT NOT NULL, categorie_jeu_id INT NOT NULL, INDEX IDX_2C5D3801AB89317 (categorie_jeu_id), INDEX IDX_2C5D38018C9E392E (jeu_id), PRIMARY KEY(jeu_id, categorie_jeu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE jeu_categorie_jeu ADD CONSTRAINT FK_2C5D38018C9E392E FOREIGN KEY (jeu_id) REFERENCES jeu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jeu_categorie_jeu ADD CONSTRAINT FK_2C5D3801AB89317 FOREIGN KEY (categorie_jeu_id) REFERENCES categorie_jeu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_jeu_jeu DROP FOREIGN KEY FK_6AE9D872AB89317');
        $this->addSql('ALTER TABLE categorie_jeu_jeu DROP FOREIGN KEY FK_6AE9D8728C9E392E');
        $this->addSql('DROP TABLE categorie_jeu_jeu');
    }
}

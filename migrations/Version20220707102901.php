<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707102901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_fritte (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, fritte_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_5C67F7B3CCD7E912 (menu_id), INDEX IDX_5C67F7B330326190 (fritte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_fritte ADD CONSTRAINT FK_5C67F7B3CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_fritte ADD CONSTRAINT FK_5C67F7B330326190 FOREIGN KEY (fritte_id) REFERENCES fritte_portion (id)');
        $this->addSql('DROP TABLE fritte_portion_menu');
        $this->addSql('ALTER TABLE boisson DROP libelle, DROP quantite');
        $this->addSql('ALTER TABLE burger DROP quantite');
        $this->addSql('ALTER TABLE commande ADD livraison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D8E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D8E54FB25 ON commande (livraison_id)');
        $this->addSql('ALTER TABLE fritte_portion DROP quantite');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F82EA2E54');
        $this->addSql('DROP INDEX IDX_A60C9F1F82EA2E54 ON livraison');
        $this->addSql('ALTER TABLE livraison ADD livreur_id INT DEFAULT NULL, DROP date_at, CHANGE commande_id zone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FF8646701 FOREIGN KEY (livreur_id) REFERENCES livreur (id)');
        $this->addSql('CREATE INDEX IDX_A60C9F1F9F2C3FAB ON livraison (zone_id)');
        $this->addSql('CREATE INDEX IDX_A60C9F1FF8646701 ON livraison (livreur_id)');
        $this->addSql('ALTER TABLE livreur DROP FOREIGN KEY FK_EB7A4E6D8E54FB25');
        $this->addSql('DROP INDEX IDX_EB7A4E6D8E54FB25 ON livreur');
        $this->addSql('ALTER TABLE livreur DROP livraison_id');
        $this->addSql('ALTER TABLE menu_boisson DROP FOREIGN KEY FK_34CD5F3734B8089');
        $this->addSql('ALTER TABLE menu_boisson DROP FOREIGN KEY FK_34CD5F3CCD7E912');
        $this->addSql('ALTER TABLE menu_boisson ADD id INT AUTO_INCREMENT NOT NULL, ADD quantite INT NOT NULL, CHANGE menu_id menu_id INT DEFAULT NULL, CHANGE boisson_id boisson_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE menu_boisson ADD CONSTRAINT FK_34CD5F3734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
        $this->addSql('ALTER TABLE menu_boisson ADD CONSTRAINT FK_34CD5F3CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D517CE5090');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D5CCD7E912');
        $this->addSql('ALTER TABLE menu_burger ADD id INT AUTO_INCREMENT NOT NULL, ADD quantite INT NOT NULL, CHANGE menu_id menu_id INT DEFAULT NULL, CHANGE burger_id burger_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D517CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id)');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D5CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE zone DROP FOREIGN KEY FK_A0EBC0078E54FB25');
        $this->addSql('DROP INDEX IDX_A0EBC0078E54FB25 ON zone');
        $this->addSql('ALTER TABLE zone DROP livraison_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fritte_portion_menu (fritte_portion_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_8D77475C562C46DF (fritte_portion_id), INDEX IDX_8D77475CCCD7E912 (menu_id), PRIMARY KEY(fritte_portion_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE fritte_portion_menu ADD CONSTRAINT FK_8D77475C562C46DF FOREIGN KEY (fritte_portion_id) REFERENCES fritte_portion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fritte_portion_menu ADD CONSTRAINT FK_8D77475CCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE menu_fritte');
        $this->addSql('ALTER TABLE boisson ADD libelle VARCHAR(255) NOT NULL, ADD quantite DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE burger ADD quantite DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D8E54FB25');
        $this->addSql('DROP INDEX IDX_6EEAA67D8E54FB25 ON commande');
        $this->addSql('ALTER TABLE commande DROP livraison_id');
        $this->addSql('ALTER TABLE fritte_portion ADD quantite DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F9F2C3FAB');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1FF8646701');
        $this->addSql('DROP INDEX IDX_A60C9F1F9F2C3FAB ON livraison');
        $this->addSql('DROP INDEX IDX_A60C9F1FF8646701 ON livraison');
        $this->addSql('ALTER TABLE livraison ADD commande_id INT DEFAULT NULL, ADD date_at DATETIME NOT NULL, DROP zone_id, DROP livreur_id');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_A60C9F1F82EA2E54 ON livraison (commande_id)');
        $this->addSql('ALTER TABLE livreur ADD livraison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livreur ADD CONSTRAINT FK_EB7A4E6D8E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('CREATE INDEX IDX_EB7A4E6D8E54FB25 ON livreur (livraison_id)');
        $this->addSql('ALTER TABLE menu_boisson MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_boisson DROP FOREIGN KEY FK_34CD5F3CCD7E912');
        $this->addSql('ALTER TABLE menu_boisson DROP FOREIGN KEY FK_34CD5F3734B8089');
        $this->addSql('ALTER TABLE menu_boisson DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE menu_boisson DROP id, DROP quantite, CHANGE menu_id menu_id INT NOT NULL, CHANGE boisson_id boisson_id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_boisson ADD CONSTRAINT FK_34CD5F3CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_boisson ADD CONSTRAINT FK_34CD5F3734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_boisson ADD PRIMARY KEY (menu_id, boisson_id)');
        $this->addSql('ALTER TABLE menu_burger MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D5CCD7E912');
        $this->addSql('ALTER TABLE menu_burger DROP FOREIGN KEY FK_3CA402D517CE5090');
        $this->addSql('ALTER TABLE menu_burger DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE menu_burger DROP id, DROP quantite, CHANGE menu_id menu_id INT NOT NULL, CHANGE burger_id burger_id INT NOT NULL');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D5CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D517CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_burger ADD PRIMARY KEY (menu_id, burger_id)');
        $this->addSql('ALTER TABLE zone ADD livraison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE zone ADD CONSTRAINT FK_A0EBC0078E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('CREATE INDEX IDX_A0EBC0078E54FB25 ON zone (livraison_id)');
    }
}

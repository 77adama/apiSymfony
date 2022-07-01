<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630224702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ligne_commande_produit');
        $this->addSql('ALTER TABLE boisson ADD ligne_commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE boisson ADD CONSTRAINT FK_8B97C84DE10FEE63 FOREIGN KEY (ligne_commande_id) REFERENCES ligne_commande (id)');
        $this->addSql('CREATE INDEX IDX_8B97C84DE10FEE63 ON boisson (ligne_commande_id)');
        $this->addSql('ALTER TABLE burger ADD ligne_commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0DE10FEE63 FOREIGN KEY (ligne_commande_id) REFERENCES ligne_commande (id)');
        $this->addSql('CREATE INDEX IDX_EFE35A0DE10FEE63 ON burger (ligne_commande_id)');
        $this->addSql('ALTER TABLE fritte_portion ADD ligne_commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fritte_portion ADD CONSTRAINT FK_9CB02144E10FEE63 FOREIGN KEY (ligne_commande_id) REFERENCES ligne_commande (id)');
        $this->addSql('CREATE INDEX IDX_9CB02144E10FEE63 ON fritte_portion (ligne_commande_id)');
        $this->addSql('ALTER TABLE menu ADD ligne_commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93E10FEE63 FOREIGN KEY (ligne_commande_id) REFERENCES ligne_commande (id)');
        $this->addSql('CREATE INDEX IDX_7D053A93E10FEE63 ON menu (ligne_commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ligne_commande_produit (ligne_commande_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_5BAB3E38E10FEE63 (ligne_commande_id), INDEX IDX_5BAB3E38F347EFB (produit_id), PRIMARY KEY(ligne_commande_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ligne_commande_produit ADD CONSTRAINT FK_5BAB3E38F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_commande_produit ADD CONSTRAINT FK_5BAB3E38E10FEE63 FOREIGN KEY (ligne_commande_id) REFERENCES ligne_commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE boisson DROP FOREIGN KEY FK_8B97C84DE10FEE63');
        $this->addSql('DROP INDEX IDX_8B97C84DE10FEE63 ON boisson');
        $this->addSql('ALTER TABLE boisson DROP ligne_commande_id');
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0DE10FEE63');
        $this->addSql('DROP INDEX IDX_EFE35A0DE10FEE63 ON burger');
        $this->addSql('ALTER TABLE burger DROP ligne_commande_id');
        $this->addSql('ALTER TABLE fritte_portion DROP FOREIGN KEY FK_9CB02144E10FEE63');
        $this->addSql('DROP INDEX IDX_9CB02144E10FEE63 ON fritte_portion');
        $this->addSql('ALTER TABLE fritte_portion DROP ligne_commande_id');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93E10FEE63');
        $this->addSql('DROP INDEX IDX_7D053A93E10FEE63 ON menu');
        $this->addSql('ALTER TABLE menu DROP ligne_commande_id');
    }
}

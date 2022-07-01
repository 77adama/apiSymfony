<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220701180609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
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
        $this->addSql('ALTER TABLE produit ADD ligne_commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27E10FEE63 FOREIGN KEY (ligne_commande_id) REFERENCES ligne_commande (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27E10FEE63 ON produit (ligne_commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
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
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27E10FEE63');
        $this->addSql('DROP INDEX IDX_29A5EC27E10FEE63 ON produit');
        $this->addSql('ALTER TABLE produit DROP ligne_commande_id');
    }
}

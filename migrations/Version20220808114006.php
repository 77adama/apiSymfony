<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220808114006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ligne_commande_produit');
        $this->addSql('ALTER TABLE produit ADD ligne_commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27E10FEE63 FOREIGN KEY (ligne_commande_id) REFERENCES ligne_commande (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27E10FEE63 ON produit (ligne_commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ligne_commande_produit (ligne_commande_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_5BAB3E38F347EFB (produit_id), INDEX IDX_5BAB3E38E10FEE63 (ligne_commande_id), PRIMARY KEY(ligne_commande_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ligne_commande_produit ADD CONSTRAINT FK_5BAB3E38F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_commande_produit ADD CONSTRAINT FK_5BAB3E38E10FEE63 FOREIGN KEY (ligne_commande_id) REFERENCES ligne_commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27E10FEE63');
        $this->addSql('DROP INDEX IDX_29A5EC27E10FEE63 ON produit');
        $this->addSql('ALTER TABLE produit DROP ligne_commande_id');
    }
}

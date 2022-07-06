<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705163645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_commande ADD produits_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74BCD11A2CF FOREIGN KEY (produits_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_3170B74BCD11A2CF ON ligne_commande (produits_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74BCD11A2CF');
        $this->addSql('DROP INDEX IDX_3170B74BCD11A2CF ON ligne_commande');
        $this->addSql('ALTER TABLE ligne_commande DROP produits_id');
    }
}

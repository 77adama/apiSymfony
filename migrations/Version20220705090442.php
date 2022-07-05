<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705090442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D9F2C3FAB');
        $this->addSql('DROP INDEX IDX_6EEAA67D9F2C3FAB ON commande');
        $this->addSql('ALTER TABLE commande DROP zone_id, CHANGE time_at time_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE zone ADD livraison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE zone ADD CONSTRAINT FK_A0EBC0078E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('CREATE INDEX IDX_A0EBC0078E54FB25 ON zone (livraison_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD zone_id INT DEFAULT NULL, CHANGE time_at time_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D9F2C3FAB ON commande (zone_id)');
        $this->addSql('ALTER TABLE zone DROP FOREIGN KEY FK_A0EBC0078E54FB25');
        $this->addSql('DROP INDEX IDX_A0EBC0078E54FB25 ON zone');
        $this->addSql('ALTER TABLE zone DROP livraison_id');
    }
}

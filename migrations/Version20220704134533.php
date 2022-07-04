<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704134533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livreur ADD livraison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livreur ADD CONSTRAINT FK_EB7A4E6D8E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('CREATE INDEX IDX_EB7A4E6D8E54FB25 ON livreur (livraison_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livreur DROP FOREIGN KEY FK_EB7A4E6D8E54FB25');
        $this->addSql('DROP INDEX IDX_EB7A4E6D8E54FB25 ON livreur');
        $this->addSql('ALTER TABLE livreur DROP livraison_id');
    }
}

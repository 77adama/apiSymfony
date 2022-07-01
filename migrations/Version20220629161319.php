<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220629161319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quartier ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962D6885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_FEE8962D6885AC1B ON quartier (gestionnaire_id)');
        $this->addSql('ALTER TABLE zone ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE zone ADD CONSTRAINT FK_A0EBC0076885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_A0EBC0076885AC1B ON zone (gestionnaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962D6885AC1B');
        $this->addSql('DROP INDEX IDX_FEE8962D6885AC1B ON quartier');
        $this->addSql('ALTER TABLE quartier DROP gestionnaire_id');
        $this->addSql('ALTER TABLE zone DROP FOREIGN KEY FK_A0EBC0076885AC1B');
        $this->addSql('DROP INDEX IDX_A0EBC0076885AC1B ON zone');
        $this->addSql('ALTER TABLE zone DROP gestionnaire_id');
    }
}

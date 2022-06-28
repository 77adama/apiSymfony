<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220627142339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boisson ADD menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE boisson ADD CONSTRAINT FK_8B97C84DCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_8B97C84DCCD7E912 ON boisson (menu_id)');
        $this->addSql('ALTER TABLE burger ADD menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0DCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_EFE35A0DCCD7E912 ON burger (menu_id)');
        $this->addSql('ALTER TABLE fritte ADD menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fritte ADD CONSTRAINT FK_8F20AF6BCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_8F20AF6BCCD7E912 ON fritte (menu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boisson DROP FOREIGN KEY FK_8B97C84DCCD7E912');
        $this->addSql('DROP INDEX IDX_8B97C84DCCD7E912 ON boisson');
        $this->addSql('ALTER TABLE boisson DROP menu_id');
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0DCCD7E912');
        $this->addSql('DROP INDEX IDX_EFE35A0DCCD7E912 ON burger');
        $this->addSql('ALTER TABLE burger DROP menu_id');
        $this->addSql('ALTER TABLE fritte DROP FOREIGN KEY FK_8F20AF6BCCD7E912');
        $this->addSql('DROP INDEX IDX_8F20AF6BCCD7E912 ON fritte');
        $this->addSql('ALTER TABLE fritte DROP menu_id');
    }
}

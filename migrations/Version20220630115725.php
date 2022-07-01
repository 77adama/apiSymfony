<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630115725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fritte_portion_menu (fritte_portion_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_8D77475C562C46DF (fritte_portion_id), INDEX IDX_8D77475CCCD7E912 (menu_id), PRIMARY KEY(fritte_portion_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fritte_portion_menu ADD CONSTRAINT FK_8D77475C562C46DF FOREIGN KEY (fritte_portion_id) REFERENCES fritte_portion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fritte_portion_menu ADD CONSTRAINT FK_8D77475CCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fritte_portion DROP FOREIGN KEY FK_9CB02144CCD7E912');
        $this->addSql('DROP INDEX IDX_9CB02144CCD7E912 ON fritte_portion');
        $this->addSql('ALTER TABLE fritte_portion DROP menu_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fritte_portion_menu');
        $this->addSql('ALTER TABLE fritte_portion ADD menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fritte_portion ADD CONSTRAINT FK_9CB02144CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_9CB02144CCD7E912 ON fritte_portion (menu_id)');
    }
}

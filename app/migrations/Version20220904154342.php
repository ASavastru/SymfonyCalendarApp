<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220904154342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointments ADD CONSTRAINT FK_6A41727AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE appointments ADD CONSTRAINT FK_6A41727A64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('CREATE INDEX IDX_6A41727AA76ED395 ON appointments (user_id)');
        $this->addSql('CREATE INDEX IDX_6A41727A64D218E ON appointments (location_id)');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointments DROP FOREIGN KEY FK_6A41727AA76ED395');
        $this->addSql('ALTER TABLE appointments DROP FOREIGN KEY FK_6A41727A64D218E');
        $this->addSql('DROP INDEX IDX_6A41727AA76ED395 ON appointments');
        $this->addSql('DROP INDEX IDX_6A41727A64D218E ON appointments');
        $this->addSql('ALTER TABLE user DROP name');
    }
}

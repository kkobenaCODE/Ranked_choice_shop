<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419172614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD is_deleted BOOLEAN DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1989D9B62 ON category (slug)');
        $this->addSql('ALTER TABLE product ALTER price SET NOT NULL');
        $this->addSql('ALTER TABLE product ALTER quantity SET NOT NULL');
        $this->addSql('ALTER TABLE product ALTER created_at SET NOT NULL');
        $this->addSql('ALTER TABLE product ALTER description SET NOT NULL');
        $this->addSql('ALTER TABLE product ALTER is_published SET NOT NULL');
        $this->addSql('ALTER TABLE product ALTER is_deleted SET NOT NULL');
        $this->addSql('ALTER TABLE product ALTER slug SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product ALTER price DROP NOT NULL');
        $this->addSql('ALTER TABLE product ALTER quantity DROP NOT NULL');
        $this->addSql('ALTER TABLE product ALTER created_at DROP NOT NULL');
        $this->addSql('ALTER TABLE product ALTER description DROP NOT NULL');
        $this->addSql('ALTER TABLE product ALTER is_published DROP NOT NULL');
        $this->addSql('ALTER TABLE product ALTER is_deleted DROP NOT NULL');
        $this->addSql('ALTER TABLE product ALTER slug DROP NOT NULL');
        $this->addSql('DROP INDEX UNIQ_64C19C1989D9B62');
        $this->addSql('ALTER TABLE category DROP is_deleted');
    }
}

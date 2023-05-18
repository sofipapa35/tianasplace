<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220503202935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiement_date_commande DROP FOREIGN KEY FK_E8BE2595A5AD869A');
        $this->addSql('DROP TABLE paiement_date');
        $this->addSql('DROP TABLE paiement_date_commande');
        $this->addSql('ALTER TABLE reservation ADD user_id INT NOT NULL, CHANGE telephone email VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_42C84955A76ED395 ON reservation (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paiement_date (id INT AUTO_INCREMENT NOT NULL, paid_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE paiement_date_commande (paiement_date_id INT NOT NULL, commande_id INT NOT NULL, INDEX IDX_E8BE259582EA2E54 (commande_id), INDEX IDX_E8BE2595A5AD869A (paiement_date_id), PRIMARY KEY(paiement_date_id, commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE paiement_date_commande ADD CONSTRAINT FK_E8BE2595A5AD869A FOREIGN KEY (paiement_date_id) REFERENCES paiement_date (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement_date_commande ADD CONSTRAINT FK_E8BE259582EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('DROP INDEX IDX_42C84955A76ED395 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP user_id, CHANGE email telephone VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

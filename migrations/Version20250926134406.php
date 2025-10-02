<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250926134406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE do_every_worker_credential (last_password_change DATETIME DEFAULT NULL, two_factor_secret VARCHAR(255) DEFAULT NULL, two_factor_recover_code_1 VARCHAR(255) DEFAULT NULL, two_factor_recover_code_1_used_at DATETIME DEFAULT NULL, two_factor_recover_code_2 VARCHAR(255) DEFAULT NULL, two_factor_recover_code_2_used_at DATETIME DEFAULT NULL, two_factor_recover_code_3 VARCHAR(255) DEFAULT NULL, two_factor_recover_code_3_used_at DATETIME DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, passkey_secret VARCHAR(255) DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, id INT AUTO_INCREMENT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, worker_id INT NOT NULL, INDEX IDX_FF2CEFE96B20BA36 (worker_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8 ENGINE = InnoDB');
        $this->addSql('ALTER TABLE do_every_worker_credential ADD CONSTRAINT FK_FF2CEFE96B20BA36 FOREIGN KEY (worker_id) REFERENCES do_every_worker (id) ON DELETE CASCADE');
        $this->addSql('
INSERT
INTO do_every_worker_credential
(
last_password_change,
two_factor_secret,
two_factor_recover_code_1,
two_factor_recover_code_1_used_at,
two_factor_recover_code_2,
two_factor_recover_code_2_used_at,
two_factor_recover_code_3,
two_factor_recover_code_3_used_at,
password,
passkey_secret,
created_by,
updated_by,
created_at,
updated_at,
worker_id)

SELECT
    last_password_change,
    two_factor_secret,
    two_factor_recover_code_1,
    two_factor_recover_code_1_used_at,
    two_factor_recover_code_2,
    two_factor_recover_code_2_used_at,
    two_factor_recover_code_3,
    two_factor_recover_code_3_used_at,
    password,
    null,
    created_by,
    updated_by,
    created_at,
    updated_at,
    id
FROM do_every_worker

');
        $this->addSql('ALTER TABLE do_every_worker DROP password, DROP last_password_change, DROP two_factor_secret, DROP two_factor_recover_code_1, DROP two_factor_recover_code_1_used_at, DROP two_factor_recover_code_2, DROP two_factor_recover_code_2_used_at, DROP two_factor_recover_code_3, DROP two_factor_recover_code_3_used_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}

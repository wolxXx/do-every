<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250926134222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('CREATE TABLE do_every_registry (id INT AUTO_INCREMENT NOT NULL, execution_reference_set_null INT DEFAULT NULL, execution_reference_cascade INT DEFAULT NULL, execution_reference_restrict INT DEFAULT NULL, group_reference_set_null INT DEFAULT NULL, group_reference_cascade INT DEFAULT NULL, group_reference_restrict INT DEFAULT NULL, task_reference_set_null INT DEFAULT NULL, task_reference_cascade INT DEFAULT NULL, task_reference_restrict INT DEFAULT NULL, worker_reference_set_null INT DEFAULT NULL, worker_reference_cascade INT DEFAULT NULL, worker_reference_restrict INT DEFAULT NULL, key_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, int_value INT DEFAULT NULL, bool_value TINYINT(1) DEFAULT NULL, string_value VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, date_value DATETIME DEFAULT NULL, created_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, updated_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, read_only TINYINT(1) DEFAULT 0 NOT NULL, visible TINYINT(1) DEFAULT 1 NOT NULL, INDEX IDX_AF551CCFBB0E6588 (group_reference_restrict), INDEX IDX_AF551CCFB44E5068 (execution_reference_restrict), UNIQUE INDEX key_name (key_name), INDEX IDX_AF551CCF9F7B7C83 (worker_reference_set_null), INDEX IDX_AF551CCF7D359BAC (task_reference_set_null), INDEX IDX_AF551CCF47B77D11 (group_reference_set_null), INDEX IDX_AF551CCF48F748F1 (execution_reference_set_null), INDEX IDX_AF551CCF1E39CF54 (worker_reference_cascade), INDEX IDX_AF551CCFE8A4F49D (task_reference_cascade), INDEX IDX_AF551CCFDF1387FC (group_reference_cascade), INDEX IDX_AF551CCF9FDF53B5 (execution_reference_cascade), INDEX IDX_AF551CCF63C2641A (worker_reference_restrict), INDEX IDX_AF551CCF818C8335 (task_reference_restrict), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE do_every_registry ADD CONSTRAINT `FK_AF551CCF1E39CF54` FOREIGN KEY (worker_reference_cascade) REFERENCES do_every_worker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE do_every_registry ADD CONSTRAINT `FK_AF551CCF47B77D11` FOREIGN KEY (group_reference_set_null) REFERENCES do_every_task_group (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE do_every_registry ADD CONSTRAINT `FK_AF551CCF48F748F1` FOREIGN KEY (execution_reference_set_null) REFERENCES do_every_task_execution (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE do_every_registry ADD CONSTRAINT `FK_AF551CCF63C2641A` FOREIGN KEY (worker_reference_restrict) REFERENCES do_every_worker (id)');
        $this->addSql('ALTER TABLE do_every_registry ADD CONSTRAINT `FK_AF551CCF7D359BAC` FOREIGN KEY (task_reference_set_null) REFERENCES do_every_task (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE do_every_registry ADD CONSTRAINT `FK_AF551CCF818C8335` FOREIGN KEY (task_reference_restrict) REFERENCES do_every_task (id)');
        $this->addSql('ALTER TABLE do_every_registry ADD CONSTRAINT `FK_AF551CCF9F7B7C83` FOREIGN KEY (worker_reference_set_null) REFERENCES do_every_worker (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE do_every_registry ADD CONSTRAINT `FK_AF551CCF9FDF53B5` FOREIGN KEY (execution_reference_cascade) REFERENCES do_every_task_execution (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE do_every_registry ADD CONSTRAINT `FK_AF551CCFB44E5068` FOREIGN KEY (execution_reference_restrict) REFERENCES do_every_task_execution (id)');
        $this->addSql('ALTER TABLE do_every_registry ADD CONSTRAINT `FK_AF551CCFBB0E6588` FOREIGN KEY (group_reference_restrict) REFERENCES do_every_task_group (id)');
        $this->addSql('ALTER TABLE do_every_registry ADD CONSTRAINT `FK_AF551CCFDF1387FC` FOREIGN KEY (group_reference_cascade) REFERENCES do_every_task_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE do_every_registry ADD CONSTRAINT `FK_AF551CCFE8A4F49D` FOREIGN KEY (task_reference_cascade) REFERENCES do_every_task (id) ON DELETE CASCADE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('CREATE TABLE do_every_session (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, content LONGTEXT CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, expires VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('CREATE TABLE do_every_task (id INT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, assignee_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, interval_type VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, interval_value INT DEFAULT NULL, priority INT NOT NULL, do_notify TINYINT(1) DEFAULT 0 NOT NULL, is_active TINYINT(1) DEFAULT 1 NOT NULL, created_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, updated_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, workingOn_id INT DEFAULT NULL, note LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, type VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT \'relative\' NOT NULL COLLATE `utf8mb3_general_ci`, due_date DATETIME DEFAULT NULL, remind_date DATETIME DEFAULT NULL, is_done TINYINT(1) DEFAULT NULL, INDEX IDX_C261364D5D276676 (workingOn_id), INDEX IDX_C261364D59EC7D60 (assignee_id), INDEX IDX_C261364DFE54D947 (group_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE do_every_task ADD CONSTRAINT `FK_C261364D59EC7D60` FOREIGN KEY (assignee_id) REFERENCES do_every_worker (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE do_every_task ADD CONSTRAINT `FK_C261364D5D276676` FOREIGN KEY (workingOn_id) REFERENCES do_every_worker (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE do_every_task ADD CONSTRAINT `FK_C261364DFE54D947` FOREIGN KEY (group_id) REFERENCES do_every_task_group (id) ON DELETE SET NULL');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('CREATE TABLE do_every_task_check_list_item (id INT AUTO_INCREMENT NOT NULL, task_id INT NOT NULL, position INT DEFAULT 0 NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, note LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, created_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, updated_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_28E901F38DB60186 (task_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE do_every_task_check_list_item ADD CONSTRAINT `FK_28E901F38DB60186` FOREIGN KEY (task_id) REFERENCES do_every_task (id) ON DELETE CASCADE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('CREATE TABLE do_every_task_execution (id INT AUTO_INCREMENT NOT NULL, task_id INT NOT NULL, worker_id INT DEFAULT NULL, date DATETIME NOT NULL, note LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, duration INT DEFAULT NULL, created_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, updated_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_3E906DE88DB60186 (task_id), INDEX IDX_3E906DE86B20BA36 (worker_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE do_every_task_execution ADD CONSTRAINT `FK_3E906DE86B20BA36` FOREIGN KEY (worker_id) REFERENCES do_every_worker (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE do_every_task_execution ADD CONSTRAINT `FK_3E906DE88DB60186` FOREIGN KEY (task_id) REFERENCES do_every_task (id) ON DELETE CASCADE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('CREATE TABLE do_every_task_execution_check_list_item (id INT AUTO_INCREMENT NOT NULL, execution_id INT NOT NULL, position INT DEFAULT 0 NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, note LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, checked TINYINT(1) DEFAULT 0 NOT NULL, created_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, updated_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, checkListItem_id INT DEFAULT NULL, INDEX IDX_3D285519C32814C2 (checkListItem_id), INDEX IDX_3D28551957125544 (execution_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE do_every_task_execution_check_list_item ADD CONSTRAINT `FK_3D28551957125544` FOREIGN KEY (execution_id) REFERENCES do_every_task_execution (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE do_every_task_execution_check_list_item ADD CONSTRAINT `FK_3D285519C32814C2` FOREIGN KEY (checkListItem_id) REFERENCES do_every_task_check_list_item (id) ON DELETE SET NULL');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('CREATE TABLE do_every_task_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, color VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, created_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, updated_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('CREATE TABLE do_every_task_notification (id INT AUTO_INCREMENT NOT NULL, task_id INT NOT NULL, worker_id INT NOT NULL, date DATETIME NOT NULL, created_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, updated_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_9AAE1368DB60186 (task_id), INDEX IDX_9AAE1366B20BA36 (worker_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE do_every_task_notification ADD CONSTRAINT `FK_9AAE1366B20BA36` FOREIGN KEY (worker_id) REFERENCES do_every_worker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE do_every_task_notification ADD CONSTRAINT `FK_9AAE1368DB60186` FOREIGN KEY (task_id) REFERENCES do_every_task (id) ON DELETE CASCADE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('CREATE TABLE do_every_task_timer (duration INT DEFAULT NULL, stopped TINYINT(1) DEFAULT 0 NOT NULL, note LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_uca1400_ai_ci`, created_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_uca1400_ai_ci`, updated_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_uca1400_ai_ci`, id INT AUTO_INCREMENT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, task_id INT NOT NULL, worker_id INT NOT NULL, INDEX IDX_6CFEB45A8DB60186 (task_id), INDEX IDX_6CFEB45A6B20BA36 (worker_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_uca1400_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE do_every_task_timer ADD CONSTRAINT `FK_6CFEB45A6B20BA36` FOREIGN KEY (worker_id) REFERENCES do_every_worker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE do_every_task_timer ADD CONSTRAINT `FK_6CFEB45A8DB60186` FOREIGN KEY (task_id) REFERENCES do_every_task (id) ON DELETE CASCADE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('CREATE TABLE do_every_task_timer_section (start DATETIME NOT NULL, end DATETIME DEFAULT NULL, created_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_uca1400_ai_ci`, updated_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_uca1400_ai_ci`, id INT AUTO_INCREMENT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, timer_id INT NOT NULL, INDEX IDX_3ABDFD0AEE98D9B9 (timer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_uca1400_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE do_every_task_timer_section ADD CONSTRAINT `FK_3ABDFD0AEE98D9B9` FOREIGN KEY (timer_id) REFERENCES do_every_task_timer (id) ON DELETE CASCADE');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('CREATE TABLE do_every_worker (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, email VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, password VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, is_admin TINYINT(1) DEFAULT 0 NOT NULL, do_notify TINYINT(1) DEFAULT 1 NOT NULL, created_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, updated_by VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, last_login DATETIME DEFAULT NULL, password_reset_token VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, password_reset_token_valid_until DATETIME DEFAULT NULL, last_password_change DATETIME DEFAULT NULL, notify_login TINYINT(1) DEFAULT 1 NOT NULL, two_factor_secret VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, two_factor_recover_code_1 VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, two_factor_recover_code_1_used_at DATETIME DEFAULT NULL, two_factor_recover_code_2 VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, two_factor_recover_code_2_used_at DATETIME DEFAULT NULL, two_factor_recover_code_3 VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, two_factor_recover_code_3_used_at DATETIME DEFAULT NULL, language VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, UNIQUE INDEX email (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('DROP TABLE `do_every_registry`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('DROP TABLE `do_every_session`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('DROP TABLE `do_every_task`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('DROP TABLE `do_every_task_check_list_item`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('DROP TABLE `do_every_task_execution`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('DROP TABLE `do_every_task_execution_check_list_item`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('DROP TABLE `do_every_task_group`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('DROP TABLE `do_every_task_notification`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('DROP TABLE `do_every_task_timer`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('DROP TABLE `do_every_task_timer_section`');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MariaDB110700Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\MariaDB110700Platform'."
        );

        $this->addSql('DROP TABLE `do_every_worker`');
    }
}

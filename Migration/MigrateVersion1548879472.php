<?php

declare(strict_types=1);

namespace Migration;

use AliceMigration\Management\Database\Database;
use AliceMigration\Migration\Migrate;

class MigrateVersion1548879472 implements Migrate
{
    /** {@inheritdoc} */
    public function up(Database $database) : void
    {
        $database->getConnection()->executeQuery("
            CREATE TABLE IF NOT EXISTS user_log_login (
                  id_user_log_login INT NOT NULL AUTO_INCREMENT,
                  id_user INT NULL,
                  dateLogin DATETIME NULL DEFAULT NOW(),
                  info TEXT NULL,
                  PRIMARY KEY (id_user_log_login)
            );
        ");
    }

    /** {@inheritdoc} */
    public function down(Database $database) : void
    {
        //$database->getConnection()->executeQuery("");
    }
}
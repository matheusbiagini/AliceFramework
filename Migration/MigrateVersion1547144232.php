<?php

declare(strict_types=1);

namespace Migration;

use AliceMigration\Management\Database\Database;
use AliceMigration\Migration\Migrate;
use App\Enum\Profile;
use App\Enum\Status;
use Infrastructure\Data\Cryptographer;

class MigrateVersion1547144232 implements Migrate
{
    /** {@inheritdoc} */
    public function up(Database $database) : void
    {
        $status   = Status::ACTIVE;
        $profile  = Profile::ADMIN;
        $password = Cryptographer::hash('123');

        $database->getConnection()->executeQuery("
            INSERT INTO user (id_profile, name, email, password, status)
            VALUES('{$profile}', 'admin', 'admin@admin.com.br', '{$password}', '{$status}');
        ");
    }

    /** {@inheritdoc} */
    public function down(Database $database) : void
    {
        $database->getConnection()->executeQuery("DELETE FROM user WHERE email = 'admin@admin.com.br';");
    }
}

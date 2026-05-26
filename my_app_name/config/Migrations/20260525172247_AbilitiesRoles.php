<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class AbilitiesRoles extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('abilities_roles');
        $table->addColumn('role_id', 'integer', [
            'limit' => 100,
        ]);
        $table->addColumn('ability_id', 'integer', [
            'limit' => 100,
        ]);
        $table->addColumn('created_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false,
        ]);
        $table->addColumn('updated_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'update' => 'CURRENT_TIMESTAMP',
            'null' => false,
        ]);

        $table->addForeignKey('role_id', 'roles', 'id');
        $table->addForeignKey('ability_id', 'abilities', 'id');

        $table->create();
    }
}

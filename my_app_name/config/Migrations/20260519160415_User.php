<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class User extends AbstractMigration
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
        $table =  $this->table('users');
        $table->addColumn('firstName', 'string', [
            'limit' => 100,
            'null' => false,
        ]);

        $table->addColumn('lastName', 'string', [
            'limit' => 100,
            'null' => false,
        ]);

        $table->addColumn('email', 'string', [
            'limit' => 100,
            'null' => false,
        ]);

        $table->addColumn('password', 'string', [
            'limit' => 100,
            'null' => false,
        ]);


        $table->addColumn('created_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);

        $table->addColumn('updated_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'update' => 'CURRENT_TIMESTAMP',
        ]);

        $table->addIndex('email', ['unique' => true]);
        $table->create();
    }
}
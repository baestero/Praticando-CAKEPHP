<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class Post extends AbstractMigration
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
        $table = $this->table('posts');

        $table->addColumn('title', 'string', [
            'limit' => 100,
            'null' => false,
        ]);

        $table->addColumn('slug', 'string', [
            'limit' => 150,
            'null' => false,
        ]);

        $table->addColumn('content', 'text', [
            'limit' => 150,
            'null' => false,
        ]);

        $table->addColumn('user_id', 'integer', [
            'null' => false,
        ]);

        $table->addColumn('created_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
        ]);

        $table->addColumn('updated_at', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP',
            'update' => 'CURRENT_TIMESTAMP',
        ]);

        $table->addForeignKey('user_id', 'users', 'id', [
            'delete' => 'CASCADE'
        ]);
        $table->create();
    }
}
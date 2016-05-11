<?php

use Migrations\AbstractMigration;

class AddPushableMembers2AtUsers extends AbstractMigration {

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change() {
        $table = $this->table('users');
        $table->addColumn('pushable_members2', 'integer', [
            'default' => 2147483647,
            'signed' => 'disabled',
            'null' => false,
            'after' => 'pushable_members',
        ]);
        $table->save();
    }

}

<?php

use Migrations\AbstractMigration;

class CreateAnalytics extends AbstractMigration {

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change() {
        $table = $this->table('analytics');
        $table->addColumn('team', 'string', [
            'default' => null,
	    'length' => 1,
            'null' => false,
        ]);
	$table->addColumn('theme', 'string', [
	    'default' => null,
	    'length' => 1,
	    'null' => false,
	]);
        $table->addColumn('code', 'string', [
            'default' => null,
	    'length' => 3,
            'null' => false,
        ]);
	$table->addColumn('count', 'integer', [
	    'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }

}

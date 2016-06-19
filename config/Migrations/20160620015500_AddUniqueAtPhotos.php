<?php

use Migrations\AbstractMigration;

class AddUniqueAtPhotos extends AbstractMigration {

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change() {
        $table = $this->table('photos');
        $table->addIndex(['url', 'post_id'], ['unique' => true]);
        $table->save();
    }

}

<?php

use Migrations\AbstractMigration;

class AddIndexAtPosts extends AbstractMigration {

    public function up() {
        parent::up();

        $table = $this->table(('posts'));
        $table->addIndex('modified');
        $table->save();
    }

    public function down() {
        parent::down();

        $table = $this->table(('posts'));
        $table->removeIndex('modified');
        $table->save();
    }

}

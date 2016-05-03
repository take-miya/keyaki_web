<?php

use Migrations\AbstractMigration;

class AddTwitterMediaUrlAtPosts extends AbstractMigration {

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change() {
        $table = $this->table('posts');
        $table->addColumn('twitter_media_url', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 255,
            'after' => 'title',
        ]);
        $table->save();
    }

}

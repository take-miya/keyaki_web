<?php
use Migrations\AbstractMigration;

class AddPublishedAtPosts extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('posts');
        $table->addColumn('published', 'datetime', [
            'default' => null,
            'null' => false,
            'after' => 'title',
        ]);
        $table->save();
    }
}

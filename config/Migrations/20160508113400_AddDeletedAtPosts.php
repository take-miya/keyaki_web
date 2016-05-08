<?php
use Migrations\AbstractMigration;

class AddDeletedAtPosts extends AbstractMigration
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
        $table->addColumn('deleted', 'datetime', [
            'default' => null,
            'null' => true,
            'after' => 'modified',
        ]);
        $table->save();
    }
}

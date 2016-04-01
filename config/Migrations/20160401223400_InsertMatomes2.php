<?php
use Migrations\AbstractMigration;

class InsertMatomes2 extends AbstractMigration
{
    public function up() {
        parent::up();
        $this->execute("INSERT INTO matomes (id, title, feed, created, modified) VALUES"
                . "(8, '欅坂46まとめ速報', 'http://keyakizaka46sokuhou.com/feed/', now(), now())"
                . "");
    }
    
    public function down() {
        parent::down();
        $this->execute("DELETE FROM matomes WHERE id = 8");
    }
}

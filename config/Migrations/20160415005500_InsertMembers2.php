<?php
use Migrations\AbstractMigration;

class InsertMembers2 extends AbstractMigration
{
    public function up() {
        parent::up();
        $this->execute("INSERT INTO members (id, name, created, modified) VALUES"
                . "(32, 'オフィシャルレポート', now(), now())"
                . "");
    }
    
    public function down() {
        parent::down();
        $this->execute("DELETE FROM members WHERE id = 32");
    }
}

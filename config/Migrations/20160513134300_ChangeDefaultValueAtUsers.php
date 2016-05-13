<?php

use Migrations\AbstractMigration;

class ChangeDefaultValueAtUsers extends AbstractMigration {

    public function up() {
        parent::up();
        $this->execute("ALTER TABLE users ALTER pushable_members SET DEFAULT -32769");
        $this->execute("ALTER TABLE users ALTER pushable_members2 SET DEFAULT -32769");
        $this->execute("ALTER TABLE users ALTER pushable_matomes SET DEFAULT -32769");
    }

    public function down() {
        parent::down();
        $this->execute("ALTER TABLE users ALTER pushable_members SET DEFAULT 2147483647");
        $this->execute("ALTER TABLE users ALTER pushable_members2 SET DEFAULT 2147483647");
        $this->execute("ALTER TABLE users ALTER pushable_matomes SET DEFAULT 2147483647");
    }

}

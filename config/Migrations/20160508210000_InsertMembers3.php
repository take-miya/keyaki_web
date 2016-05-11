<?php
use Migrations\AbstractMigration;

class InsertMembers3 extends AbstractMigration
{
    public function up() {
        parent::up();
        $this->execute("INSERT INTO members (id, name, created, modified) VALUES"
                . "(23, '井口 眞緒', now(), now()),"
                . "(24, '潮 紗理菜', now(), now()),"
                . "(25, '柿崎 芽実', now(), now()),"
                . "(26, '影山 優佳', now(), now()),"
                . "(27, '加藤 史帆', now(), now()),"
                . "(28, '齊藤 京子', now(), now()),"
                . "(29, '佐々木 久美', now(), now()),"
                . "(30, '佐々木 美玲', now(), now()),"
                . "(31, '高瀬 愛奈', now(), now()),"
                . "(32, '高本 彩花', now(), now()),"
                . "(33, '東村 芽依', now(), now())"
                . "");
    }
    
    public function down() {
        parent::down();
        $this->execute("DELETE FROM members WHERE id <= 33 AND id >= 23");
    }
}

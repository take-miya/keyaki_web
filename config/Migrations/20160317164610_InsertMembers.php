<?php
use Migrations\AbstractMigration;

class InsertMembers extends AbstractMigration
{
    public function up() {
        parent::up();
        $this->execute("INSERT INTO members (id, name, created, modified) VALUES"
                . "(1, '石森 虹花', now(), now()),"
                . "(2, '今泉 佑唯', now(), now()),"
                . "(3, '上村 莉菜', now(), now()),"
                . "(4, '尾関 梨香', now(), now()),"
                . "(5, '織田 奈那', now(), now()),"
                . "(6, '小池 美波', now(), now()),"
                . "(7, '小林 由依', now(), now()),"
                . "(8, '齋藤 冬優花', now(), now()),"
                . "(9, '佐藤 詩織', now(), now()),"
                . "(10, '志田 愛佳', now(), now()),"
                . "(11, '菅井 友香', now(), now()),"
                . "(12, '鈴本 美愉', now(), now()),"
                . "(13, '長沢 菜々香', now(), now()),"
                . "(14, '土生 瑞穂', now(), now()),"
                . "(15, '原田 葵', now(), now()),"
                . "(17, '平手 友梨奈', now(), now()),"
                . "(18, '守屋 茜', now(), now()),"
                . "(19, '米谷 奈々未', now(), now()),"
                . "(20, '渡辺 梨加', now(), now()),"
                . "(21, '渡邉 理佐', now(), now()),"
                . "(22, '長濱 ねる', now(), now())"
                . "");
    }
    
    public function down() {
        parent::down();
        $this->execute("DELETE FROM members WHERE id <= 22");
    }
}

<?php

use Migrations\AbstractMigration;

class InsertPosts extends AbstractMigration {

    public function up() {
        parent::up();
        $this->execute("INSERT INTO posts (id, member_id, title, published, created, modified) VALUES"
                . "(2539, 999, '「サイレントマジョリティー」ジャケット写真・アーティスト写真メイキングレポート', '2016-04-16 21:00:00', now(), now()),"
                . "(2522, 999, '欅坂46 デビューシングル発売日に渋谷CDショップをジャック!', '2016-04-16 19:00:00', now(), now()),"
                . "(2218, 999, '「欅坂46生中継!デビューカウントダウンライブ!!」レポート', '2016-03-25 00:00:00', now(), now()),"
                . "(1822, 999, '「ニッポン放送 LIVE EXPO TOKYO 2016 ALL LIVE NIPPON VOL.4」欅坂46ライブレポート', '2016-02-04 00:00:00', now(), now()),"
                . "(1821, 999, '「新春!おもてなし会」レポート', '2016-01-20 00:00:00', now(), now()),"
                . "(1820, 999, '2016年 初詣レポート', '2016-01-14 21:00:00', now(), now()),"
                . "(1819, 999, '「欅坂46ミニ握手会～12/20 富士見、港北」レポート', '2016-12-20 00:00:00', now(), now()),"
                . "(1818, 999, '「欅坂46ミニ握手会～12/19 豊洲、昭島、東大和」レポート', '2016-12-19 00:00:00', now(), now())"
                . "");
    }

    public function down() {
        parent::down();
        $this->execute("DELETE FROM members WHERE id = 999");
    }

}

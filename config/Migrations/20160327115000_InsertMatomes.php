<?php
use Migrations\AbstractMigration;

class InsertMatomes extends AbstractMigration
{
    public function up() {
        parent::up();
        $this->execute("INSERT INTO matomes (id, title, feed, created, modified) VALUES"
                . "(1, '欅坂46まとめきんぐだむ', 'http://toriizaka46.jp/feed/', now(), now()),"
                . "(2, '欅坂46まとめちゃんねる', 'http://keyakizaka46ch.jp/feed/', now(), now()),"
                . "(3, '欅坂46速報', 'http://keyakizaka1.blog.jp/index.rdf', now(), now()),"
                . "(4, '欅坂46まとめ坂', 'http://keyakizakamatome.blog.jp/index.rdf', now(), now()),"
                . "(5, '欅坂46まとめもり～', 'http://keyaki46.2chblog.jp/index.rdf', now(), now()),"
                . "(6, '欅坂46まとめラボ', 'http://www.keyakizaka46matomerabo.com/index.rdf', now(), now()),"
                . "(7, '欅坂46トリまとめ', 'http://keyakizaka46torimatome.com/feed/', now(), now())"
                . "");
    }
    
    public function down() {
        parent::down();
        $this->execute("DELETE FROM matomes WHERE id <= 6");
    }
}

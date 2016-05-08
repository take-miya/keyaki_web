<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

require_once(WWW_ROOT . "php/phpQuery-onefile.php");

class CheckDeletedBlogShell extends Shell {

    public function main() {
        $posts = TableRegistry::get('Posts')->find()->where(['deleted IS' => null])->all();
        foreach ($posts as $post) {
            $postUrl = \Cake\Core\Configure::read('post.url').$post->id;
var_dump('check url: '.$postUrl);
            $page = file_get_contents($postUrl);

            $phpQuery = \phpQuery::newDocument($page);
            foreach ($phpQuery['h2'] as $h2) {
                if (pq($h2)->text() == 'ページが見つかりませんでした') {
var_dump('404 url: '. $postUrl);
                    $post->deleted = strtotime('now');
                    TableRegistry::get('Posts')->save($post);
                }
            }
        }
    }
}

<?php

namespace App\Shell;

require_once(WWW_ROOT . "php/phpQuery-onefile.php");

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

class CrawlPostTextShell extends Shell {

    public function main() {
        $posts = TableRegistry::get('Posts')->find()->where(['text IS' => NULL]);

        foreach ($posts as $post) {
            if (!$post) {
                return;
            }
            $postUrl = \Cake\Core\Configure::read('post.url') . $post->id;
var_dump($postUrl);
            $page = file_get_contents($postUrl);
            $page = preg_replace('<meta http-equiv="content-type" content="text/html; charset=[0-9a-zA-Z_]+">', '', $page);

            if ($page) {
                $phpQuery = \phpQuery::newDocument($page);
                $count = 0;
                $imgPath = [];
                $post->text = htmlspecialchars(pq($phpQuery['.box-article'])->text());
            } else {
                \Cake\Log\Log::error('cannot fetch blog url:' . $postUrl);
            }
            $post->modified = $post->modified;
            TableRegistry::get('Posts')->save($post);
            sleep(5);
        }
    }

}

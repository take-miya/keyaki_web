<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

require_once(WWW_ROOT . "php/phpQuery-onefile.php");

class CrawlOldBlogShell extends Shell {

    public function main() {
        $base = 'http://www.keyakizaka46.com/mob/news/diarKiji.php?site=k46o&ima=4652&rw=20&cd=member&page=';
        for ($i = 0; $i < 10; $i++) {
            $url = $base . $i;
var_dump($url);
            $page = file_get_contents($url);
            $page = preg_replace('<meta http-equiv="content-type" content="text/html; charset=[0-9a-zA-Z_]+">', '', $page);
            $phpQuery = \phpQuery::newDocument($page);
            $flag = false;
            foreach ($phpQuery->find('article') as $article) {
                $flag = true;
                $a = pq($article)->find('h3')->find('a');
                $postTitle = trim($a->text());
var_dump($postTitle);
                $postUrl = pq($a)->attr('href');              
                $postMemberName = trim(pq($article)['.name']->text());
var_dump($postMemberName);
                foreach (pq($article)['.box-bottom']->find('ul')->find('li') as $li) {
                    $postTime = \DateTime::createFromFormat('Y/m/d H:i:s', trim(pq($li)->text()) . ':00');
                    break;
                }

                preg_match('/id=(\d+)/', $postUrl, $m);
                $postId = (int) $m[1];
                if (TableRegistry::get('Posts')->exists(['id' => $postId])) {
                } else {
                    $member = TableRegistry::get('Members')->find()->where(['name' => $postMemberName])->first();
                    $post = TableRegistry::get('Posts')->newEntity(['id' => $postId, 'member_id' => $member->id, 'title' => $postTitle, 'published' => $postTime]);
                    TableRegistry::get('Posts')->save($post, ['push' => true]);
                }
            }
            if (!$flag) {
                break;
            }
        }
    }

}

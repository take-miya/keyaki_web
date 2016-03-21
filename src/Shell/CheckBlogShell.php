<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

require_once(WWW_ROOT . "php/phpQuery-onefile.php");

class CheckBlogShell extends Shell {

    public function main() {
        $url = \Cake\Core\Configure::read('blog.url');
        $page = file_get_contents($url);
        $phpQuery = \phpQuery::newDocument($page);
        foreach ($phpQuery['.slider']->find('ul')->find('li') as $li) {
            $postUrl = pq($li)->find('a')->attr('href');
            $c = 0;
            foreach (pq($li)['.box-blog']->find('p') as $p) {
                if ($c === 0) {
                    $postTitle = trim(pq($p)->text());
                    $c++;
                } elseif ($c === 1) {
                    $postMemberName = trim(pq($p)->text());
                    break;
                }
            }
            preg_match('/id=(\d+)/', $postUrl, $m);
            $postId = (int) $m[1];
            if (TableRegistry::get('Posts')->exists(['id' => $postId])) {
                break;
            } else {
                $member = TableRegistry::get('Members')->find()->where(['name' => $postMemberName])->first();
                $post = TableRegistry::get('Posts')->newEntity(['id' => $postId, 'member_id' => $member->id, 'title' => $postTitle]);
                TableRegistry::get('Posts')->save($post);
            }
        }
    }

}

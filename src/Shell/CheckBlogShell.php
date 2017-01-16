<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

require_once(WWW_ROOT . "php/phpQuery-onefile.php");

class CheckBlogShell extends Shell {

    public function main() {
        $url = \Cake\Core\Configure::read('blog.url');
        $page = file_get_contents($url);
        $page = preg_replace('<meta http-equiv="content-type" content="text/html; charset=[0-9a-zA-Z_]+">', '', $page);
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
            foreach (pq($li)['.box-blog']->find('time') as $time) {
                $postTime = \DateTime::createFromFormat('Y.m.d H:i:s', pq($time)->text() . ':00');
                break;
            }
            preg_match('/\/s\/k46o\/diary\/detail\/(\d+)/', $postUrl, $m);
            $postId = (int) $m[1];
            if (TableRegistry::get('Posts')->exists(['id' => $postId])) {
                continue;
            } else {
                $member = TableRegistry::get('Members')->find()->where(['name' => $postMemberName])->first();
                $post = TableRegistry::get('Posts')->newEntity(['id' => $postId, 'title' => $postTitle, 'published' => $postTime, 'deleted' => null]);
                $post->member = $member;
                TableRegistry::get('Posts')->save($post, ['push' => true]);
            }
        }

        foreach ($phpQuery['.box-manageBlog']->find('ul')->find('li') as $li) {
            $postUrl = pq($li)->find('a')->attr('href');
            $c = 0;
            $postTitle = trim(pq($li)['.txt']->text());
            $postTime = \DateTime::createFromFormat('Y.m.d', pq($li)->find('time')->text());

            if (preg_match('/id=(\d+)/', $postUrl, $m)) {
                $postId = (int) $m[1];
            } else {
                break;
            }
            if (TableRegistry::get('Posts')->exists(['id' => $postId])) {
                break;
            } else {
                $member = TableRegistry::get('Members')->get(999);
                $post = TableRegistry::get('Posts')->newEntity(['id' => $postId, 'title' => $postTitle, 'published' => $postTime]);
                $post->member = $member;
                TableRegistry::get('Posts')->save($post, ['push' => true]);
            }
        }
    }

}

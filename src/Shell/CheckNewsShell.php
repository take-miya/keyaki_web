<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

require_once(WWW_ROOT . "php/phpQuery-onefile.php");

class CheckNewsShell extends Shell {

    public function main() {
        $url = \Cake\Core\Configure::read('top.url');
        $page = file_get_contents($url);
        $phpQuery = \phpQuery::newDocument($page);
        foreach ($phpQuery['.news']->find('ul')->find('li') as $li) {
            $a = pq($li)->find('a');
            $topicUrl = pq($li)->find('a')->attr('href');
            $topicTitle = pq($li)->find('a')->text();
            $topicTime = \DateTime::createFromFormat('Y.m.d H:i:s', pq($li)->find('time')->text().' 00:00:00');

            preg_match('/cd=([A-Za-z0-9]+)/', $topicUrl, $m);
            $topicId = $m[1];
            if (TableRegistry::get('Topics')->exists(['id' => $topicId])) {
                break;
            } else {
                $topic = TableRegistry::get('Topics')->newEntity(['id' => $topicId, 'title' => $topicTitle, 'published' => $topicTime]);
                TableRegistry::get('Topics')->save($topic, ['push' => true]);
            }
        }
    }

}

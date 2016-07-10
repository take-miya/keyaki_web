<?php

namespace App\Shell;

use Cake\Console\Shell;

require_once(WWW_ROOT . "php/phpQuery-onefile.php");

class FetchMediaUrlShell extends Shell {

    public function main() {
        for ($i = 1; $i < 213; $i++) {
            $url = 'http://www.keyakizaka46.com/mob/news/newsShw.php?site=k46o&cd=M' . str_pad($i, 5, 0, STR_PAD_LEFT);
            var_dump('check url:' . $url);
            $page = file_get_contents($url);
            $phpQuery = \phpQuery::newDocument($page);
            foreach ($phpQuery['.article']->find('a') as $a) {
                $href = pq($a)->attr('href');
                var_dump('media url:' . $href);
            }
        }
    }

}

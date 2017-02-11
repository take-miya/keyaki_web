<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

require_once(WWW_ROOT . "php/phpQuery-onefile.php");

class CheckDeletedPhotoShell extends Shell {

    public function main() {
        $photos = TableRegistry::get('Photos')->find()->where(['deleted IS' => null])->order(['id' => 'DESC'])->all();
        foreach ($photos as $photo) {
var_dump($photo->id);
            $context = stream_context_create(array(
                'http' => array('ignore_errors' => true)
            ));
            $res = file_get_contents($photo->url, false, $context);
            $pos = strpos($http_response_header[0], '200');
            if ($pos === false) {
var_dump($photo->url);
                $photo->deleted = strtotime('now');
                TableRegistry::get('Photos')->save($photo);
            }
            usleep(100000);
        }
    }
}

<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

class CheckMatomesShell extends Shell {

    public function main() {
        $matomes = TableRegistry::get('Matomes')->find()->where(['deleted IS' => null]);
        foreach ($matomes as $matome) {
            $xml = simplexml_load_file($matome->feed);
            if (preg_match("/rdf/", $matome->feed)) {
                $xmlItems = $xml->item;
            } elseif (preg_match("/feed/", $matome->feed)) {
                $xmlItems = $xml->channel->item;
            } else {
                break;
            }

            foreach ($xmlItems as $i) {
                $item = TableRegistry::get('Items')->newEntity(['title' => $i->title, 'url' => $i->link]);
                $item->matome = $matome;
                if (TableRegistry::get('Items')->exists(['matome_id' => $matome->id, 'url' => $item->url])) {
                    break;
                } else {
                    TableRegistry::get('Items')->save($item, ['push' => true]);
                }
            }
        }
    }

}

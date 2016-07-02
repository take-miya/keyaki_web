<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Network\Http\Client;

/**
 * Item Entity.
 *
 * @property int $id
 * @property int $matome_id
 * @property \App\Model\Entity\Matome $matome
 * @property string $title
 * @property string $url
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 */
class Item extends AppEntity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    public function push() {
        $http = new Client();
        $matomeIdBit = 1 << ($this->matome_id - 1);
        $tokens = \Cake\ORM\TableRegistry::get('Users')->find('list')->where(['pushable_matomes &' => $matomeIdBit])->toArray();
        $data = ['url' => "{$this->url}"];
        parent::push($tokens, $this->matome->title, 'TAKEMIYA_KEYAKI_NOTIFICATION_MATOME_UPDATE', $this->title, $data);
    }

}

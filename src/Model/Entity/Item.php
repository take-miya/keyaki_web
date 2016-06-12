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
class Item extends Entity {

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
        // ToDo: tokens.length > 1000 のとき、分割処理
        $request = [
            'registration_ids' => array_values($tokens),
            'notification' => [
                'title' => $this->matome->title,
                'icon' => '@mipmap/notification',
                'click_action' => 'TAKEMIYA_KEYAKI_NOTIFICATION_MATOME_UPDATE',
                'body' => $this->title,
                'sound' => 'default',
            ],
            'data' => [
                'url' => "{$this->url}",
            ],
        ];
        \Cake\Log\Log::debug('request: ' . json_encode($request));
        $response = $http->post('https://gcm-http.googleapis.com/gcm/send', json_encode($request), ['type' => 'json', 'headers' => ['Authorization' => 'key=' . \Cake\Core\Configure::read('gcm.api_key')]]);
        \Cake\Log\Log::debug('response: ' . $response->body());
    }

}

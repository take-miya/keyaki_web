<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Network\Http\Client;

/**
 * Topic Entity.
 *
 * @property string $id
 * @property string $title
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 */
class Topic extends Entity {

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
    ];
    
    protected $_hidden = [
        'created',
        'modified',
    ];

    public function push() {
        $http = new Client();
        $tokens = \Cake\ORM\TableRegistry::get('Users')->find('list')->toArray();
        // ToDo: tokens.length > 1000 のとき、分割処理
        $request = [
            'registration_ids' => array_values($tokens),
            'notification' => [
                'title' => '欅坂46ニュース',
                'icon' => '@mipmap/notification',
                'click_action' => 'TAKEMIYA_KEYAKI_NOTIFICATION_OFFICIAL_NEWS_UPDATE',
                'body' => $this->title,
                'sound' => 'default',
                'color' => '#a0d468',
            ],
            'data' => [
                'url' => \Cake\Core\Configure::read('news.url')."{$this->id}",
            ],
        ];
        \Cake\Log\Log::debug('request: '.json_encode($request)); 
        $response = $http->post('https://gcm-http.googleapis.com/gcm/send', json_encode($request), ['type' => 'json', 'headers' => ['Authorization' => 'key=' . \Cake\Core\Configure::read('gcm.api_key')]]);
        \Cake\Log\Log::debug('response: '. $response->body());
    }

}

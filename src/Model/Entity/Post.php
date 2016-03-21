<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Network\Http\Client;

/**
 * Post Entity.
 *
 * @property int $id
 * @property int $member_id
 * @property \App\Model\Entity\Member $member
 * @property string $title
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 */
class Post extends Entity {

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

    public function push() {
        $http = new Client();
        $tokens = \Cake\ORM\TableRegistry::get('Users')->find(['field' => 'token'])->where(['deleted' => 'null'])->toArray();
        // ToDo: tokens.length > 1000 のとき、分割処理
        $response = $http->post('https://gcm-http.googleapis.com/gcm/send', [
            'registration_ids' => $tokens,
            'notification' => [
                'title' => 'keyaki',
                'icon' => '@drawable/notification',
                'click_action' => 'KEYAKIAPP_NOTIFICATION_OFFICIAL_BLOG_UPDATE',
                'body' => 'ブログ更新通知',
                'sound' => 'default',
                'color' => '#a0d468',
            ],
                ], ['type' => 'json', 'headers' => ['Authorization' => 'key=' . 'AIzaSyD0Pv1ffpwS8T1Inlkb1oFDh4DhFzdRA_E']]);
    }
}

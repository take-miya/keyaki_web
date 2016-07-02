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
class Post extends AppEntity {

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
        if ($this->member_id < 33) {
            $memberIdBit = 1 << ($this->member_id - 1);
            $tokens = \Cake\ORM\TableRegistry::get('Users')->find('list')->where(['pushable_members &' => $memberIdBit])->toArray();
        } elseif ($this->member_id < 65) {
            $memberIdBit = 1 << ($this->member_id - 33);
            $tokens = \Cake\ORM\TableRegistry::get('Users')->find('list')->where(['pushable_members2 &' => $memberIdBit])->toArray();
        } else {
            $tokens = \Cake\ORM\TableRegistry::get('Users')->find('list')->toArray();
        }$data = ['url' => \Cake\Core\Configure::read('post.url').$this->id];
        self::gcm($tokens, $this->member->name, 'TAKEMIYA_KEYAKI_NOTIFICATION_OFFICIAL_BLOG_UPDATE', $this->title, $data);
    }

}

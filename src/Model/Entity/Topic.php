<?php

namespace App\Model\Entity;

/**
 * Topic Entity.
 *
 * @property string $id
 * @property string $title
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 */
class Topic extends AppEntity {

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
        $tokens = \Cake\ORM\TableRegistry::get('Users')->find('list')->toArray();
        $data = ['url' => \Cake\Core\Configure::read('news.url')."{$this->id}"];
        self::gcm($tokens, '欅坂46ニュース', 'TAKEMIYA_KEYAKI_NOTIFICATION_OFFICIAL_NEWS_UPDATE', $this->title, $data);
    }

}

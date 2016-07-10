<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Page Entity.
 *
 * @property int $id
 * @property string $url
 * @property string $page_title
 * @property string $site_title
 * @property \Cake\I18n\Time $published
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 */
class Page extends Entity {

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
}

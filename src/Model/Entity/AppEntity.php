<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Network\Http\Client;

/**
 * App Entity.
 */
class AppEntity extends Entity {

    public static function gcm($tokens, $title, $action, $body, $data) {
        $http = new Client();
        $chunkedTokens = array_chunk($tokens, 1000, true);
        foreach ($chunkedTokens as $t) {
                    $request = [
            'registration_ids' => array_values($t),
            'priority' => 'high',
            'notification' => [
                'title' => $title,
                'icon' => '@mipmap/notification',
                'click_action' => $action,
                'body' => $body,
                'sound' => 'default',
            ],
            'data' => $data,
        ];
        \Cake\Log\Log::debug('request: '.json_encode($request)); 
        $response = $http->post('https://gcm-http.googleapis.com/gcm/send', json_encode($request), ['type' => 'json', 'headers' => ['Authorization' => 'key=' . \Cake\Core\Configure::read('gcm.api_key')]]);
        \Cake\Log\Log::debug('response: '. $response->body());
        }
    }
}

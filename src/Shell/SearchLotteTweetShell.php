<?php

namespace App\Shell;

require_once(ROOT . "/vendor/abraham/twitteroauth/autoload.php");

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Abraham\TwitterOAuth\TwitterOAuth;

class SearchLotteTweetShell extends Shell {

    public function main() {
	$search_key = "#つぶやきCM -RT";
	$options = ['q' => $search_key, 'count' => '100'];

	$since_id = TableRegistry::get('Tweets')->find()->max('id')->id;
	if ($since_id){
    		$options['since_id'] = (string)$since_id; //前回の最後に取得したツイートIDから
	}
var_dump($options);
	$twObj = new TwitterOAuth("z6WEG2AL0ozYvnjY2zoNgRH6i", "WV4YECZBWmDzxXEa0gJdISgxFXy3cjLdq2bFvvHChz8DMuFFrO", "727086553428688898-nSVZbnnEBsUqNj7FN1Y1ukUOb64fkKp", "yIdsiyC7tqotRQAQ1QULGrPUF41CRvB9V0kXH58o0jhD2");

	$json_data = $twObj->get('search/tweets',$options);
	$statuses = null;
	if ($json_data){
    		$statuses = $json_data->statuses; //ステータス情報取得
	}
	if ($statuses && is_array($statuses)) {
    		$sts_cnt = count($statuses);
var_dump($sts_cnt);
    		// 一番古いデータからDBへ書き込む
    		for ($i = $sts_cnt-1; $i >= 0; $i--) {
        		$result = $statuses[$i];
			$tweet = TableRegistry::get('Tweets')->newEntity();
        		$tweet->tweeted = date('Y-m-d H:i:s', strtotime($result->created_at));
        		$tweet->id = $result->id;
        		$text = $result->text;
			$item = $result->entities->urls;
 
			if (isset($item)){
        			foreach ($item as $url) {
            				$tco_url = (string)$url->url;
            				$long_url = (string)$url->expanded_url;
            				$text = str_replace($tco_url,$long_url,$text); //置換
        			}
				$tweet->text = $text;
				TableRegistry::get('Tweets')->save($tweet);
    			}
    		}
    	}
    }
}

<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Abraham\TwitterOAuth\TwitterOAuth;

class AnalyzeLotteTweetShell extends Shell {

    public function main() {
	$tweets = TableRegistry::get('Tweets')->find();
	foreach ($tweets as $tweet) {
		$text = $tweet->text;
		if (preg_match('/http:\/\/lottegum.jp\/shr\/([kh])([1-6])(00)/', $text, $m)) {
			$team = $m[1];
			$theme = $m[2];
			$codes = str_split($m[3], 2);
			foreach ($codes as $code) {
var_dump($team.$theme.$code);
				$analytic = TableRegistry::get('Analytics')->find()->where(['team' => $team, 'theme' => $theme, 'code' => $code])->first();
				if (!$analytic) {
					$analytic = TableRegistry::get('Analytics')->newEntity();
					$analytic->team = $team;
					$analytic->theme = $theme;
					$analytic->code = $code;
				}
				$analytic->count += 1;
				TableRegistry::get('Analytics')->save($analytic);
			}
		}
		
	}
    	
    }
}

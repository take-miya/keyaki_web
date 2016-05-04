<?php

namespace App\Shell;

require_once(ROOT . "/vendor/abraham/twitteroauth/autoload.php");
require_once(WWW_ROOT . "php/phpQuery-onefile.php");

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Abraham\TwitterOAuth\TwitterOAuth;

class TweetMediaShell extends Shell {

    public function main() {
        while (1) {
            $post = TableRegistry::get('Posts')->find()->where(['twitter_media_url IS' => NULL])->first();
            if (!$post) {
                return;
            }
            $postUrl = \Cake\Core\Configure::read('post.url').$post->id;
            $page = file_get_contents($postUrl);
        
            $post->twitter_media_url = '';
            if ($page) {
                $phpQuery = \phpQuery::newDocument($page);
                $count = 0;
                $imgPath = [];
                foreach ($phpQuery['.box-article']->find('img') as $img) {
                    $src = $img->getAttribute('src');
                    $img = file_get_contents('http://www.keyakizaka46.com/'.$src);
                    $path = '/data/img/'.$post->id.'-'.$count.'.jpg';
                    file_put_contents($path, $img); 
                    $imgPath[] = $path;
                    $count++;
                    if ($count >= 4) {
                        break;
                    }
                }
                if (count($imgPath) > 0) {
                    $post->twitter_media_url = self::tweetPost($postUrl, self::uploadMedia($imgPath));
                } else {
                    \Cake\Log\Log::error('no image url:'.$postUrl);
                }
            } else {
                \Cake\Log\Log::error('cannot fetch blog url:'.$postUrl);
            }
            TableRegistry::get('Posts')->save($post);
            if ($post->twitter_media_url == '') {
                return;
            }
        }
    }

    private static function uploadMedia($imgPath) {
        $mediaIds = [];
        $connection = self::getConnection();
        foreach ($imgPath as $path) {
            $media = $connection->upload('media/upload', ['media' => $path]);
            $mediaIds[] = $media->media_id_string;
        }
        return $mediaIds;
    }

    private static function tweetPost($url, $mediaIds = null) {
        $connection = self::getConnection();
        $parameters = [
            'status' => $url,
            'media_ids' => implode(',', $mediaIds),
        ];
        $statuses = $connection->post("statuses/update", $parameters);
        if ($connection->getLastHttpCode() == 200) {
            return $statuses->extended_entities->media[0]->display_url;
        } else {
            \Cake\Log\Log::error('url:'.$url);
            return '';
        } 
    }

    private static function getConnection() {
        return new TwitterOAuth("z6WEG2AL0ozYvnjY2zoNgRH6i", "WV4YECZBWmDzxXEa0gJdISgxFXy3cjLdq2bFvvHChz8DMuFFrO", "727086553428688898-nSVZbnnEBsUqNj7FN1Y1ukUOb64fkKp", "yIdsiyC7tqotRQAQ1QULGrPUF41CRvB9V0kXH58o0jhD2");
        }
    }

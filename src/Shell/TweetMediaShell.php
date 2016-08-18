<?php

namespace App\Shell;

require_once(ROOT . "/vendor/abraham/twitteroauth/autoload.php");
require_once(WWW_ROOT . "php/phpQuery-onefile.php");

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Abraham\TwitterOAuth\TwitterOAuth;

class TweetMediaShell extends Shell {

    public function main() {
        $posts = TableRegistry::get('Posts')->find()->where(['twitter_media_url IS' => NULL]);
        //$posts = TableRegistry::get('Posts')->find()->where(['id'=>4464]);

        foreach ($posts as $post) {
            if (!$post) {
                return;
            }
            $postUrl = \Cake\Core\Configure::read('post.url') . $post->id;
            var_dump($postUrl);
            $page = file_get_contents($postUrl);
            $page = preg_replace('<meta http-equiv="content-type" content="text/html; charset=[0-9a-zA-Z_]+">', '', $page);

            $post->twitter_media_url = '';
            if ($page) {
                $phpQuery = \phpQuery::newDocument($page);
                $count = 0;
                $imgPath = [];
                foreach ($phpQuery['.box-article']->find('img') as $img) {
                    $src = $img->getAttribute('src');
                    if ($src == '') {
                        continue;
                    }
                    $src = 'http://www.keyakizaka46.com' . $src;
                    var_dump($src);
                    $photo = TableRegistry::get('Photos')->newEntity();
                    $photo->url = $src;
                    $photo->post_id = $post->id;
                    TableRegistry::get('Photos')->save($photo);
                    if (preg_match('/gif$/', $src)) {
                        continue;
                    }
                    $img = file_get_contents($src);
                    if (!$img) {
                        $count++;
                        continue;
                    }
                    $path = '/data/img/' . $post->id . '-' . $count . '.jpg';
                    file_put_contents($path, $img);
                    $imgPath[] = $path;
                    $count++;
                }
                if (count($imgPath) > 0) {
                    $post->twitter_media_url = self::tweetPost($postUrl, self::uploadMedia($imgPath));
                    if ($post->twitter_media_url == '') {
                        continue;
                    }
                } else {
                    \Cake\Log\Log::error('no image url:' . $postUrl);
                }
            } else {
                \Cake\Log\Log::error('cannot fetch blog url:' . $postUrl);
            }
            TableRegistry::get('Posts')->save($post);
        }
    }

    private static function uploadMedia($imgPath) {
        $mediaIds = [];
        $connection = self::getConnection();
        foreach ($imgPath as $path) {
            $media = $connection->upload('media/upload', ['media' => $path]);
            if ($connection->getLastHttpCode() == 200) {
                $mediaIds[] = $media->media_id_string;
            } else {
                \Cake\Log\Log::error('cannot upload image path:' . $path);
                return [];
            }
        }
        return $mediaIds;
    }

    private static function tweetPost($url, $mediaIds) {
        if (count($mediaIds) == 0) {
            return '';
        }
        $mediaIds = array_slice($mediaIds, 0, 4);
        $connection = self::getConnection();
        $parameters = [
            'status' => $url,
            'media_ids' => implode(',', $mediaIds),
        ];
        $statuses = $connection->post("statuses/update", $parameters);
        if ($connection->getLastHttpCode() == 200) {
            return $statuses->extended_entities->media[0]->display_url;
        } else {
            \Cake\Log\Log::error('url:' . $url);
            return '';
        }
    }

    private static function getConnection() {
        return new TwitterOAuth("z6WEG2AL0ozYvnjY2zoNgRH6i", "WV4YECZBWmDzxXEa0gJdISgxFXy3cjLdq2bFvvHChz8DMuFFrO", "727086553428688898-nSVZbnnEBsUqNj7FN1Y1ukUOb64fkKp", "yIdsiyC7tqotRQAQ1QULGrPUF41CRvB9V0kXH58o0jhD2");
    }

}

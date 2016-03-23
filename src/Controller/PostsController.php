<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 */
class PostsController extends AppController {

    public function index() {
        $this->autoRender = false;
        $updatedFrom = '2000-01-01T00:00:00+0900';
        if (isset($this->request->query['updated_from'])) {
            $updatedFrom = $this->request->query['updated_from'];
        }
        if ($this->request->is('get')) {
            $posts = $this->Posts->find()->where(['modified >' => $updatedFrom]);
            $last_updated = $this->Posts->find()->max('modified')->modified;
            $result = 'success';
        }
        echo json_encode(compact('result', 'last_updated', 'posts'));
    }
}

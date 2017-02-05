<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 */
class PagesController extends AppController {

    public function index() {
        $this->response->sharable(true, 3600);
        $this->autoRender = false;
        $updatedFrom = '2000-01-01T00:00:00+0900';
        if (isset($this->request->query['updated_from'])) {
            $updatedFrom = $this->request->query['updated_from'];
        }
        if ($this->request->is('get')) {
            $pages = $this->Pages->find()->where(['modified >' => $updatedFrom])->orderDesc('modified');
            $last_updated = $this->Pages->find()->max('modified')->modified;
            $result = 'success';
        }
        echo json_encode(compact('result', 'last_updated', 'pages'));
    }
}

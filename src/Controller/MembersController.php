<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Members Controller
 *
 * @property \App\Model\Table\MembersTable $Members
 */
class MembersController extends AppController
{

    public function index() {
        $this->response->sharable(true, 3600);
        $this->autoRender = false;
        $updatedFrom = '2000-01-01T00:00:00+0900';
        if (isset($this->request->query['updated_from'])) {
            $updatedFrom = $this->request->query['updated_from'];
        }
        if ($this->request->is('get')) {
            $members = $this->Members->find()->where(['modified >' => $updatedFrom]);
            $last_updated = $this->Members->find()->max('modified')->modified;
            $result = 'success';
        }
        echo json_encode(compact('result', 'last_updated', 'members'));
    }

}

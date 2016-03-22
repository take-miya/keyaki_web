<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController {

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $user = $this->Users->newEntity($this->request->data('user'));
            if ($this->Users->save($user)) {
                $result = 'success';
            } else {
                $result = 'error';
                $message = $user->errors();
            }
        }
        echo json_encode(compact('result', 'message', 'user'));
    }

}

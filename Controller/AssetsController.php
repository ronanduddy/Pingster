<?php

App::uses('AppController', 'Controller');

/**
 * Assets Controller
 *
 * @property Asset $Asset
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AssetsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Asset->recursive = 0;
        $this->set('assets', $this->Paginator->paginate());
    }

    public function admin_index() {
        $this->Asset->recursive = 0;
        $this->set('assets', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Asset->exists($id)) {
            throw new NotFoundException(__('Invalid asset'));
        }
        $options = array('conditions' => array('Asset.' . $this->Asset->primaryKey => $id));
        $this->set('asset', $this->Asset->find('first', $options));
    }

    public function admin_view($id = null) {
        if (!$this->Asset->exists($id)) {
            throw new NotFoundException(__('Invalid asset'));
        }
        $options = array('conditions' => array('Asset.' . $this->Asset->primaryKey => $id));
        $this->set('asset', $this->Asset->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Asset->create();
            if ($this->Asset->save($this->request->data)) {
                $this->Session->setFlash(__('The asset has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The asset could not be saved. Please, try again.'));
            }
        }
        $users = $this->Asset->User->find('list');
        $projects = $this->Asset->Project->find('list');
        $this->set(compact('users', 'projects'));
    }

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Asset->create();
            if ($this->Asset->save($this->request->data)) {
                $this->Session->setFlash(__('The asset has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The asset could not be saved. Please, try again.'));
            }
        }
        $users = $this->Asset->User->find('list');
        $projects = $this->Asset->Project->find('list');
        $this->set(compact('users', 'projects'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Asset->exists($id)) {
            throw new NotFoundException(__('Invalid asset'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Asset->save($this->request->data)) {
                $this->Session->setFlash(__('The asset has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The asset could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Asset.' . $this->Asset->primaryKey => $id));
            $this->request->data = $this->Asset->find('first', $options);
        }
        $users = $this->Asset->User->find('list');
        $projects = $this->Asset->Project->find('list');
        $this->set(compact('users', 'projects'));
    }

    public function admin_edit($id = null) {
        if (!$this->Asset->exists($id)) {
            throw new NotFoundException(__('Invalid asset'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Asset->save($this->request->data)) {
                $this->Session->setFlash(__('The asset has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The asset could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Asset.' . $this->Asset->primaryKey => $id));
            $this->request->data = $this->Asset->find('first', $options);
        }
        $users = $this->Asset->User->find('list');
        $projects = $this->Asset->Project->find('list');
        $this->set(compact('users', 'projects'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Asset->id = $id;
        if (!$this->Asset->exists()) {
            throw new NotFoundException(__('Invalid asset'));
        }
        $this->request->allowMethod('post', 'delete');

        // saved to pingster/user/project/asset/image.png
        $asset = $this->Asset->findById($id);
        $urlBits = explode('pingster/', $asset['Asset']['asset_url']);

        // delete
        if ($this->Asset->delete() && $this->Amazon->S3->delete_object($this->s3_bucket, $urlBits[1])) {

            $this->Session->setFlash('The asset has been deleted.', 'Flashes/success');
        } else {
            $this->Session->setFlash('The asset could not be deleted. Please, try again.', 'Flashes/danger');
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_delete($id = null) {
        $this->delete($id);
    }

}

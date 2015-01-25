<?php

App::uses('AppController', 'Controller');

/**
 * Groups Controller
 *
 * @property Group $Group
 * @property PaginatorComponent $Paginator
 */
class GroupsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Group->recursive = 0;
        $this->set('groups', $this->Paginator->paginate());
    }

    public function admin_index() {
        $this->index();
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Group->exists($id)) {
            throw new NotFoundException(__('Invalid group'));
        }
        $options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
        $this->set('group', $this->Group->find('first', $options));
    }

    public function admin_view($id = null) {
        $this->view($id);
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Group->create();
            if ($this->Group->save($this->request->data)) {
                $this->Session->setFlash('The group has been saved.', 'Flashes/success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The group could not be saved. Please, try again.', 'Flashes/warning');
            }
        }
    }

    public function admin_add() {
        $this->add();
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Group->exists($id)) {
            throw new NotFoundException(__('Invalid group'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Group->save($this->request->data)) {
                $this->Session->setFlash('The group has been edited.', 'Flashes/success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The group could not be edited. Please, try again.', 'Flashes/warning');
            }
        } else {
            $options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
            $this->request->data = $this->Group->find('first', $options);
        }
    }

    public function admin_edit($id = null) {
        $this->edit($id);
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Group->id = $id;
        if (!$this->Group->exists()) {
            throw new NotFoundException(__('Invalid group'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Group->delete()) {
            $this->Session->setFlash('The group has been deleted.', 'Flashes/success');
        } else {
            $this->Session->setFlash('The group could not be deleted. Please, try again.', 'Flashes/success');
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_delete($id = null) {
        $this->delete($id);
    }

}

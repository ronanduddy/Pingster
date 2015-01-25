<?php
App::uses('AppController', 'Controller');
/**
 * AssetsProjects Controller
 *
 * @property AssetsProject $AssetsProject
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AssetsProjectsController extends AppController {

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
		$this->AssetsProject->recursive = 0;
		$this->set('assetsProjects', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->AssetsProject->exists($id)) {
			throw new NotFoundException(__('Invalid assets project'));
		}
		$options = array('conditions' => array('AssetsProject.' . $this->AssetsProject->primaryKey => $id));
		$this->set('assetsProject', $this->AssetsProject->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->AssetsProject->create();
			if ($this->AssetsProject->save($this->request->data)) {
				$this->Session->setFlash(__('The assets project has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The assets project could not be saved. Please, try again.'));
			}
		}
		$assets = $this->AssetsProject->Asset->find('list');
		$projects = $this->AssetsProject->Project->find('list');
		$this->set(compact('assets', 'projects'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->AssetsProject->exists($id)) {
			throw new NotFoundException(__('Invalid assets project'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->AssetsProject->save($this->request->data)) {
				$this->Session->setFlash(__('The assets project has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The assets project could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('AssetsProject.' . $this->AssetsProject->primaryKey => $id));
			$this->request->data = $this->AssetsProject->find('first', $options);
		}
		$assets = $this->AssetsProject->Asset->find('list');
		$projects = $this->AssetsProject->Project->find('list');
		$this->set(compact('assets', 'projects'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->AssetsProject->id = $id;
		if (!$this->AssetsProject->exists()) {
			throw new NotFoundException(__('Invalid assets project'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->AssetsProject->delete()) {
			$this->Session->setFlash(__('The assets project has been deleted.'));
		} else {
			$this->Session->setFlash(__('The assets project could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}

<?php
App::uses('AppController', 'Controller');
/**
 * CommunitiesProjects Controller
 *
 * @property CommunitiesProject $CommunitiesProject
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CommunitiesProjectsController extends AppController {

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
		$this->CommunitiesProject->recursive = 0;
		$this->set('communitiesProjects', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CommunitiesProject->exists($id)) {
			throw new NotFoundException(__('Invalid communities project'));
		}
		$options = array('conditions' => array('CommunitiesProject.' . $this->CommunitiesProject->primaryKey => $id));
		$this->set('communitiesProject', $this->CommunitiesProject->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CommunitiesProject->create();
			if ($this->CommunitiesProject->save($this->request->data)) {
				$this->Session->setFlash(__('The communities project has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The communities project could not be saved. Please, try again.'));
			}
		}
		$projects = $this->CommunitiesProject->Project->find('list');
		$communities = $this->CommunitiesProject->Community->find('list');
		$this->set(compact('projects', 'communities'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CommunitiesProject->exists($id)) {
			throw new NotFoundException(__('Invalid communities project'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CommunitiesProject->save($this->request->data)) {
				$this->Session->setFlash(__('The communities project has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The communities project could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CommunitiesProject.' . $this->CommunitiesProject->primaryKey => $id));
			$this->request->data = $this->CommunitiesProject->find('first', $options);
		}
		$projects = $this->CommunitiesProject->Project->find('list');
		$communities = $this->CommunitiesProject->Community->find('list');
		$this->set(compact('projects', 'communities'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CommunitiesProject->id = $id;
		if (!$this->CommunitiesProject->exists()) {
			throw new NotFoundException(__('Invalid communities project'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CommunitiesProject->delete()) {
			$this->Session->setFlash(__('The communities project has been deleted.'));
		} else {
			$this->Session->setFlash(__('The communities project could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->CommunitiesProject->recursive = 0;
		$this->set('communitiesProjects', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->CommunitiesProject->exists($id)) {
			throw new NotFoundException(__('Invalid communities project'));
		}
		$options = array('conditions' => array('CommunitiesProject.' . $this->CommunitiesProject->primaryKey => $id));
		$this->set('communitiesProject', $this->CommunitiesProject->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CommunitiesProject->create();
			if ($this->CommunitiesProject->save($this->request->data)) {
				$this->Session->setFlash(__('The communities project has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The communities project could not be saved. Please, try again.'));
			}
		}
		$projects = $this->CommunitiesProject->Project->find('list');
		$communities = $this->CommunitiesProject->Community->find('list');
		$this->set(compact('projects', 'communities'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->CommunitiesProject->exists($id)) {
			throw new NotFoundException(__('Invalid communities project'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CommunitiesProject->save($this->request->data)) {
				$this->Session->setFlash(__('The communities project has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The communities project could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CommunitiesProject.' . $this->CommunitiesProject->primaryKey => $id));
			$this->request->data = $this->CommunitiesProject->find('first', $options);
		}
		$projects = $this->CommunitiesProject->Project->find('list');
		$communities = $this->CommunitiesProject->Community->find('list');
		$this->set(compact('projects', 'communities'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->CommunitiesProject->id = $id;
		if (!$this->CommunitiesProject->exists()) {
			throw new NotFoundException(__('Invalid communities project'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CommunitiesProject->delete()) {
			$this->Session->setFlash(__('The communities project has been deleted.'));
		} else {
			$this->Session->setFlash(__('The communities project could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}

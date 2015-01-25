<?php
App::uses('AppController', 'Controller');
/**
 * ProjectsTags Controller
 *
 * @property ProjectsTag $ProjectsTag
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProjectsTagsController extends AppController {

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
		$this->ProjectsTag->recursive = 0;
		$this->set('projectsTags', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ProjectsTag->exists($id)) {
			throw new NotFoundException(__('Invalid projects tag'));
		}
		$options = array('conditions' => array('ProjectsTag.' . $this->ProjectsTag->primaryKey => $id));
		$this->set('projectsTag', $this->ProjectsTag->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ProjectsTag->create();
			if ($this->ProjectsTag->save($this->request->data)) {
				$this->Session->setFlash(__('The projects tag has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The projects tag could not be saved. Please, try again.'));
			}
		}
		$tags = $this->ProjectsTag->Tag->find('list');
		$projects = $this->ProjectsTag->Project->find('list');
		$this->set(compact('tags', 'projects'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ProjectsTag->exists($id)) {
			throw new NotFoundException(__('Invalid projects tag'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ProjectsTag->save($this->request->data)) {
				$this->Session->setFlash(__('The projects tag has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The projects tag could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ProjectsTag.' . $this->ProjectsTag->primaryKey => $id));
			$this->request->data = $this->ProjectsTag->find('first', $options);
		}
		$tags = $this->ProjectsTag->Tag->find('list');
		$projects = $this->ProjectsTag->Project->find('list');
		$this->set(compact('tags', 'projects'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ProjectsTag->id = $id;
		if (!$this->ProjectsTag->exists()) {
			throw new NotFoundException(__('Invalid projects tag'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ProjectsTag->delete()) {
			$this->Session->setFlash(__('The projects tag has been deleted.'));
		} else {
			$this->Session->setFlash(__('The projects tag could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}

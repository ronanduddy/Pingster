<?php

App::uses('AppController', 'Controller');

/**
 * Communities Controller
 *
 * @property Community $Community
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CommunitiesController extends AppController {

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
        $this->Paginator->settings = array(
            'limit' => 10,
            'order' => array('Community.name' => 'asc'),
            'recursive' => -1
        );
        $this->set('communities', $this->Paginator->paginate());

//        $options = array(
//            'fields' => array('*', 'COUNT(CommunitiesProject.project_id) as TotalProjects'),
//            'group' => 'CommunitiesProject.community_id',
//            'recursive' => 0
//,        );
        $options = array(
            //  'fields' => array('*', 'COUNT(CommunitiesProject.project_id) as TotalProjects'),
            'fields' => array('*',),
            // 'group' => 'CommunitiesProject.community_id',
            'recursive' => 1
                ,);
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Community->exists($id)) {
            throw new NotFoundException(__('Invalid community'));
        }
        // get name of community for view
        $options = array('conditions' => array(
                'Community.' . $this->Community->primaryKey => $id),
            'fields' => array('Community.name', 'Community.id'),
            'recursive' => -1,
        );
        $this->set('community', $this->Community->find('first', $options));


        // options for getting project ids from link table 
        $options = array(
            'conditions' => array(
                'AND' => array(
                    'CommunitiesProject.community_id' => $id
                ),
            ),
            'fields' => array(
                'CommunitiesProject.project_id'
            )
        );

        // find all project ids that are associated with the community (from link table)
        $CommunitiesProject = $this->Community->CommunitiesProject->find('list', $options);

        // debug($CommunitiesProject);
        //exit();
        // getting projects
        $this->Paginator->settings = array(
            'conditions' => array(
                'AND' => array(
                    'Project.id' => $CommunitiesProject,
                    'Project.status' => 'public'
                ),
            ),
            'limit' => 10,
            'order' => array('Project.created' => 'desc'),
            'recursive' => -1
        );

        $projects = $this->Paginator->paginate('Project');
        $this->set(compact('projects'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Community->create();
            if ($this->Community->save($this->request->data)) {
                $this->Session->setFlash(__('The community has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The community could not be saved. Please, try again.'));
            }
        }
        $projects = $this->Community->Project->find('list');
        $this->set(compact('projects'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Community->exists($id)) {
            throw new NotFoundException(__('Invalid community'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Community->save($this->request->data)) {
                $this->Session->setFlash(__('The community has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The community could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Community.' . $this->Community->primaryKey => $id));
            $this->request->data = $this->Community->find('first', $options);
        }
        $projects = $this->Community->Project->find('list');
        $this->set(compact('projects'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Community->id = $id;
        if (!$this->Community->exists()) {
            throw new NotFoundException(__('Invalid community'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Community->delete()) {
            $this->Session->setFlash(__('The community has been deleted.'));
        } else {
            $this->Session->setFlash(__('The community could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Community->recursive = 0;
        $this->set('communities', $this->Paginator->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->Community->exists($id)) {
            throw new NotFoundException(__('Invalid community'));
        }
        $options = array('conditions' => array('Community.' . $this->Community->primaryKey => $id));
        $this->set('community', $this->Community->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Community->create();
            if ($this->Community->save($this->request->data)) {
                $this->Session->setFlash(__('The community has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The community could not be saved. Please, try again.'));
            }
        }
        $projects = $this->Community->Project->find('list');
        $this->set(compact('projects'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->Community->exists($id)) {
            throw new NotFoundException(__('Invalid community'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Community->save($this->request->data)) {
                $this->Session->setFlash(__('The community has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The community could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Community.' . $this->Community->primaryKey => $id));
            $this->request->data = $this->Community->find('first', $options);
        }
        $projects = $this->Community->Project->find('list');
        $this->set(compact('projects'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Community->id = $id;
        if (!$this->Community->exists()) {
            throw new NotFoundException(__('Invalid community'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Community->delete()) {
            $this->Session->setFlash(__('The community has been deleted.'));
        } else {
            $this->Session->setFlash(__('The community could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}

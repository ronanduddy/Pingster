<?php

App::uses('AppController', 'Controller');


class NotificationsController extends AppController {
    /**
     * read method. Marks the notification read and redirects to the target (if any)
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function read($id = null) {

        $this->Notification->id = $id;
        if (!$this->Notification->exists()) {
            throw new NotFoundException(__('Invalid notification'));
        }
        $this->Notification->id = $id;
        $this->Notification->saveField('is_read', 1);
        $this->Notification->recursive = -1;
        $item = $this->Notification->read(null, $id);
        if (!isset($item['Notification']['target'])) {
            $target = $this->redirect($this->referer('/'));
        } else {
            $target = $this->redirect($item['Notification']['target']);
        }
        $this->redirect($target);
    }
    /**
     * delete method. Deletes a single notification
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {

        $this->Notification->id = $id;

        if ($this->request->is('ajax')) {

            $this->layout = false;
            $this->autoRender = false;
            if (!$this->Notification->exists()) {
                return 0;
            }
            if (!$this->Notification->delete()) {
                return 0;
            } else {
                return 1;
            }
        } else {

            if (!$this->Notification->exists()) {
                throw new NotFoundException(__('Invalid notification'));
            }
            if (!$this->Notification->delete()) {
                $this->Session->setFlash(__('Notification was not deleted'));
            }
            $this->redirect($this->referer('/'));
        }
    }
    /**
     * Delete all the notifications for the current user
     *
     * @return void
     */
    public function deleteAll() {

        if (!$this->Notification->deleteAll(array('user_id' => $this->Auth->user('id')))) {
            $this->Session->setFlash(__('Notifications are not deleted'));
        }
        $this->redirect($this->referer('/'));
    }
    /**
     * Marks all the notifications read for the current user
     *
     * @return void
     */
    public function markAllRead() {

        $this->autoRender = false;

        if (!$this->Notification->markAllRead($this->Auth->user('id'))) {
            $this->Session->setFlash(__('Failed to mark all read'));
        }
    }
}
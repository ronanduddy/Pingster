<?php

/**
 * Set up a Ping and attach it, with an image and comment,
 * to the admin user
 */
class ProjectSeeder
{
  /**
   * Asset model
   *
   * @access private
   * @var Asset
   */
  private $Asset;

  /**
   * Project model
   *
   * @access private
   * @var Project
   */
  private $Project;

  /**
   * Seed shell
   *
   * @access private
   * @var BasicSeedShell
   */
  private $SeedShell;

  /**
   * Constructor
   */
  public function __construct($SeedShell)
  {
    $this->Asset = ClassRegistry::init('Asset');
    $this->Project = ClassRegistry::init('Project');
    $this->SeedShell = $SeedShell;
  }

  /**
   * Execute the seeder
   */
  public function run()
  {
    $this->init_pings();
  }

  /**
   * Give the admin user a Ping
   */
  private function init_pings()
  {
    //STARTHERE
    public function addProject($kind=Project::KIND_PING) {
        $user = $this->Auth->user();
        $s3_bucket = Configure::read('Pingster.s3_bucket');

        if ($this->request->is('post')) {
            $this->Project->create();

            if (!empty($this->request->data) && $this->request->data['Project']['image']['size'] != 0) {

                // tmp vars as request data will be nulled
                $tmp_name = $this->request->data['Project']['image']['tmp_name'];
                $name = $this->request->data['Project']['image']['name'];

                $this->request->data['Project']['image_url'] = null;
                $this->request->data['Project']['image'] = null;
                $this->request->data['Project']['kind'] = $kind;

                if ($this->Project->saveAssociated($this->request->data)) {

                    // upload to aws
                    $finfo = new finfo(FILEINFO_MIME);
                    if ($finfo) {
                        $file_name = $tmp_name;
                        $file_info = $finfo->file($file_name);
                        $mime_type = substr($file_info, 0, strpos($file_info, ';'));

                        $user = $this->Auth->user();
                        // save to pingster/user/project/image.png
                        $saveTo = sprintf('%s/%s/%s', $user['id'], $this->Project->id, $name);

                        $result = $this->Amazon->S3->putObject(array(
                            'Bucket' => $s3_bucket,
                            'Key' => $saveTo,
                            'SourceFile' => $tmp_name,
                            'ACL' => 'public-read',
                            'ContentType' => $mime_type
                        ));

                        $this->Project->set('image_url', $result['ObjectURL']);
                    }

                    // set project.image_url to the request_url etc.
                    $this->Project->set('image', $name);

                    // record
                    $this->Project->save();

                    // community project is member of
                    if ($kind == Project::KIND_PING) {

                        $community_id = $this->request->data['Project']['community'];
                        if (isset($community_id) && $community_id != NULL) {
                            $this->Project->CommunitiesProject->create();
                            $this->Project->CommunitiesProject->save(array('project_id' => $this->Project->id, 'community_id' => $community_id));
                        }
                    }
                    elseif ($kind == Project::KIND_PING) {

                        if (isset($this->request->data['Project']['user_ids'])){

                            $project_members = explode(',',$this->request->data['Project']['user_ids']);
                            $owner = $this->Auth->user();

                            foreach($project_members as $member){

                                if($user_id = intval($member)){

                                    $this->Project->ProjectsUser->create();
                                    $this->Project->ProjectsUser->save(
                                        array(
                                            'project_id' => $this->Project->id,
                                            'user_id' => $user_id,
                                            'user_role' => ProjectsUser::USER_ROLE_COLLABORATOR,
                                            'accepted_invitation' => 0
                                        )
                                    );


                                    $url = '/Projects/viewTeamUp/' . $this->Project->id;
                                    $message = $owner['username'] . " wants to team up! <a id='notification_url' href='".$url."'>Check it out!</a>";
                                    $this->Project->User->Notification->msg($user_id, $message);

                                }
                            }
                        }
                    }


                    $message = 'Ping created.';
                    if ($this->request->is('ajax'))
                    {
                      $success = true;

                      $this->set(compact('message', 'success'));
                      $this->set('_serialize', ['message', 'success']);

                      return;
                    }
                    else
                    {
                      $this->Session->setFlash($message, 'Flashes/success');
                      $action = $kind == Project::KIND_PING ? 'viewPing' : 'viewTeamUp';
                      if ($user['group_id'] == 1) {
                          return $this->redirect(array('action' => $action, $this->Project->id, 'admin' => false));
                      } else {
                          return $this->redirect(array('action' => $action, $this->Project->id));
                      }
                    }
                }
            } else {
                $message = 'The Ping could not be saved. Please, try again.';
                if ($this->request->is('ajax'))
                {
                    $success = false;

                    $this->set(compact('message', 'success'));
                    $this->set('_serialize', ['message', 'success']);

                    return;
                }
                else
                {
                    $this->Session->setFlash('The Ping could not be saved. Please, try again.', 'Flashes/warning');
                    return $this->redirect(array('action' => 'myPings'));
                }
            }
        }

        // if any parameters are being passed to controller
        if (isset($this->request->params['named'])) {
            $namedParams = $this->request->params['named'];
        }

        if($kind == Project::KIND_TEAM_UP){

           $users = $this->Project->User->find(
           'list',
            array(
                'fields' => array('User.username'),
                'recursive' => 0
            ));
           $this->set(compact('user', 'users', 'params'));
        }
        $communities = $this->Project->Community->find('list');

        //FIXME: include team up
        $partial = ($kind != Project::KIND_TEAM_UP && $this->request->is('ajax'));

        $this->set(compact('user', 'communities', 'namedParams', 'partial'));
//        $assets = $this->Project->Asset->find('list');
//        $users = $this->Project->User->find('list');
//        $this->set(compact('assets', 'users'));
    }
  }
}

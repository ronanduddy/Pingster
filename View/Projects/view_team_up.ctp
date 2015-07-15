<?php //debug($community);           ?>

<script>
var project_id = <?php echo $project["Project"]["id"]; ?>;
</script>
<div class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>
<div class="col-lg-6">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-rocket"></i>
            <h3 class="box-title">
                <?php echo sprintf('%s <small>%s %s</small>', h($project['Project']['title']), h(ucfirst($project['Project']['status'])), h(ucfirst($project['Project']['kind']))); ?>
            </h3>
        </div>
        <div class="box-body">
            <p>
                <?php
                echo sprintf('Started by %s (%s) on %s', $this->Html->link($project['User']['username'], array(
                            'controller' => 'users',
                            'action' => 'view',
                            h($project['User']['id'])
                        )), h($project['ProjectsUser']['user_role']), $this->Time->nice($project['Project']['created'])
                );

                ?>
                </p>
            <div class="thumbnail">
                <?php
                // get path info => extension
                $pathinfo = pathinfo($project['Project']['image_url']);
                ?>
                <?php if ( isset($pathinfo['extension']) && in_array(strtolower($pathinfo['extension']), array('jpg', 'jpeg', 'gif', 'png', 'apng', 'svg', 'bmp', 'ico'))) : ?>
                    <?php
                    echo $this->Html->image(
                            $project['Project']['image_url'], array(
                        'class' => 'lazy',
                        'data-original' => $project['Project']['image_url']
                    ));
                    ?>
                <?php else: ?>
                    <?php
                    echo $this->Html->image(
                            null, array(
                        'data-src' => 'holder.js/100%x300/random/text:' . h(str_replace(' ', ' \n ', $project['Project']['title']))
                    ));
                    ?>
                <?php endif; ?>
            </div>
            <p><?php

                if($project['Project']['tags']){

                    $tags = explode(',', $project['Project']['tags']);
                    echo "<p>";
                    foreach($tags as $tag){
                        echo '<a href="/Search/explore?term='.$tag.'">'.$tag.'</a>';
                    }

                    echo "</p>";
                }

                echo h($project['Project']['description']); ?></p>
        </div>
        <div class="box-footer" style="text-align: right">
            <div class="btn-group" >
                <?php
// if owner or admin
                if ($current_user['id'] == $project['ProjectsUser']['user_id'] || $current_user['Group']['name'] == 'admins') {
                    echo $this->Html->link('Edit Team Up', array('controller' => 'Projects', 'action' => 'editTeamUp', $project['Project']['id']), array('title' => 'Edit this Team Up?', 'class' => 'btn btn-primary'));
                    echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->params['pass'][0], '?' => array('kind' => $project['Project']['kind'])), array('title' => 'Delete this Ping', 'class' => 'btn btn-danger'), __('Are you sure you want to delete me!?'));
                    echo $this->element('loveButton');
                }
                ?>

            </div>
        </div>
    </div>
</div>

<?php
    foreach($ProjectUsers as $ProjectUser){
        if($current_user['id'] == $ProjectUser['id'] && !$ProjectUser['accepted_invitation']){
            echo $this->element('showInvitation');
        }
    }
?>

<div class="col-lg-6">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-users"></i>
            <h3 class="box-title">
                A-Team
            </h3>
        </div>
        <div class="box-body">

            <ul class="list-group">
                <?php
                if(!empty($ProjectUsers)){
                    foreach($ProjectUsers as $user){
                        echo '<li class="list-group-item">';
                        echo $this->Html->link($user['username'], array(
                            'controller' => 'users',
                            'action' => 'view',
                            h($user['id'])
                        ));
                        if(!$user['accepted_invitation']){
                            echo " (Invitation sent)";
                        }
//                        echo '<a class="fa fa-times"></a>';
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>
        <div class="box-footer" style="text-align: right">

        </div>
    </div>
</div>

<?php
echo $this->element('addComment');

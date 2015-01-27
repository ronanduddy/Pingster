<?php //debug($project);   ?>
<div class="col-lg-6">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-folder-open-o"></i>
            <h3 class="box-title">
                <?php echo sprintf('%s <small>%s %s</small>', h($project['Project']['title']), h(ucfirst($project['Project']['status'])), h(ucfirst($project['Project']['kind']))); ?>
            </h3>
        </div>
        <div class="box-body">
            <?php if ($current_user['group_id'] == 1) : ?>
                <div class="callout callout-warning">
                    <h4>Known Issue</h4>
                    <p>When editing a ping you will be directed to a 'Missing View' page.</p>
                    <p>When deleting a ping you will be logged out, but the ping will still be deleted. It's recommended to delete the ping from the 'Projects' link on the left.</p>
                </div>
            <?php endif; ?>
            <div class="thumbnail">
                <?php echo $this->Html->image($project['Project']['image_url']); ?>
            </div>
            <p><?php echo h($project['Project']['description']); ?></p>
            <p>
                <?php
                echo sprintf('Started by %s (%s) on %s', $this->Html->link($project['User']['username'], array(
                            'controller' => 'users',
                            'action' => 'view',
                            h($project['User']['id'])
                        )), h($project['ProjectsUser']['user_role']), h(date("d F, Y", strtotime($project['Project']['created']))));
                ?>
            </p>
        </div>
        <div class="box-footer" style="text-align: right">
            <div class="btn-group" >
                <?php
                // if owner or admin
                if ($current_user['id'] == $project['ProjectsUser']['user_id'] || $current_user['Group']['id'] == 1) {
                    echo $this->Html->link('Edit Ping', array('controller' => 'Projects', 'action' => 'editPing', $project['Project']['id']), array('title' => 'Edit this Ping?', 'class' => 'btn btn-primary'));
                    echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->params['pass'][0], '?' => array('kind' => $project['Project']['kind'])), array('title' => 'Delete this Ping', 'class' => 'btn btn-danger'), __('Are you sure you want to delete me!?'));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php echo $this->element('addComment');
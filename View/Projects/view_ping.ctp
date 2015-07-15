<?php //debug($community);           ?>
<div class="col-lg-6">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-folder-open-o"></i>
            <h3 class="box-title">
                <?php echo sprintf('%s <small>%s %s - %s Views</small>', h($project['Project']['title']), h(ucfirst($project['Project']['status'])), h(ucfirst($project['Project']['kind'])), $Views); ?>
            </h3>
        </div>
        <div class="box-body">
            <p>
                <?php
                echo sprintf('Started by %s (%s) on %s and ', $this->Html->link($project['User']['username'], array(
                            'controller' => 'users',
                            'action' => 'view',
                            h($project['User']['id'])
                        )), h($project['ProjectsUser']['user_role']), $this->Time->nice($project['Project']['created'])
                );

                if (!empty($community)) {
                    echo sprintf('is part of the %s community.', $this->Html->link($community['Community']['name'], array(
                                'controller' => 'communities',
                                'action' => 'view',
                                h($community['Community']['id'])), array('class' => 'btn btn-info btn-sm')
                    ));
                } else {
                    echo 'is not yet a part of a community.';
                }
                ?>
            </p>
            <div class="thumbnail">
                <?php
                // get path info => extension
                $pathinfo = pathinfo($project['Project']['image_url']);
                ?>
                <?php if (in_array(strtolower($pathinfo['extension']), array('jpg', 'jpeg', 'gif', 'png', 'apng', 'svg', 'bmp', 'ico'))) : ?>
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
                    echo $this->Html->link('Edit Ping', array('controller' => 'Projects', 'action' => 'editPing', $project['Project']['id']), array('title' => 'Edit this Ping?', 'class' => 'btn btn-primary'));
                    echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->params['pass'][0], '?' => array('kind' => $project['Project']['kind'])), array('title' => 'Delete this Ping', 'class' => 'btn btn-danger'), __('Are you sure you want to delete me!?'));
                    echo $this->element('loveButton');
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
echo $this->element('addComment');

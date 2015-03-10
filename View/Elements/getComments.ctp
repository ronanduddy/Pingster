<?php
//debug($commentsList);
?> 
<?php if (!empty($commentsList)): ?>

    <div class="content">

        <ul class="timeline">

            <?php
            $day = 0;
            ?>

            <?php foreach ($commentsList as $comment): ?>

                <?php if ($day == 0) : ?>
                    <li class="time-label">
                        <span class="bg-blue-gradient"> 
                            <?php
                            echo $this->Time->timeAgoInWords($comment['Comment']['created'], array('format' => 'F jS, Y', 'end' => '+1 year'));
                            $day = date("d", strtotime($comment['Comment']['created']));
                            ?>
                        </span>
                    </li>
                <?php elseif ($day != date("d", strtotime($comment['Comment']['created']))): ?>
                    <li class="time-label">
                        <span class="bg-blue-gradient"> 
                            <?php
                            echo $this->Time->timeAgoInWords($comment['Comment']['created'], array('format' => 'F jS, Y', 'end' => '+1 year'));
                            $day = date("d", strtotime($comment['Comment']['created']));
                            ?>
                        </span>
                    </li>
                <?php endif; ?>

                <li>
                    <i class="fa fa-comment"></i>
                    <div class="timeline-item">
                        <span class="time">
                            <small class="text-muted">
                                <i class="fa fa-clock-o"></i> 
                                <?php echo $this->Time->niceshort($comment['Comment']['created']); ?>
                            </small>
                        </span>

                        <h3 class="timeline-header">        
                            <i class="fa fa-user"></i>
                            <?php
                            echo $this->Html->link($comment['User']['username'], array(
                                'controller' => 'users',
                                'action' => 'view',
                                $comment['User']['id']
                            ));
                            ?>
                        </h3>

                        <div class="timeline-body" style="border-bottom: 1px solid #f4f4f4">
                            <?php if ($comment['Comment']['asset_id'] != null) : ?>
                                <div class="thumbnail" style="height:300px;">
                                    <?php
                                    // get path info => extension
                                    $pathinfo = pathinfo($comment['Asset']['asset_url']);
                                    ?>
                                    <?php if (in_array(strtolower($pathinfo['extension']), array('jpg', 'jpeg', 'gif', 'png', 'apng', 'svg', 'bmp', 'ico'))) : ?>
                                        <?php
                                        echo $this->Html->image(
                                                $comment['Asset']['asset_url'], array(
                                            'class' => 'lazy',
                                            'data-original' => $comment['Asset']['asset_url']
                                        ));
                                        ?>
                                    <?php else: ?>
                                        <?php
                                        echo $this->Html->image(
                                                null, array(
                                            'data-src' => 'holder.js/100%x100%/random/text:' . h(str_replace(' ', ' \n ', $comment['Asset']['asset']))
                                        ));
                                        ?>
                                    <?php endif; ?>                                   
                                </div>
                            <?php endif; ?>
                            <p class="message">                    
                                <?php echo h($comment['Comment']['comment']); ?>                   
                            </p>
                        </div>

                        <div class="timeline-footer">
                            <div class="clearfix">
                                <?php
                                if ($comment['Comment']['asset_id'] != null) {
                                    echo $this->Html->link('Download ' . $comment['Asset']['asset'], $comment['Asset']['asset_url'], array('class' => 'btn btn-primary pull-left', 'target' => '_blank', 'title' => 'Download ' . $comment['Asset']['asset_url']));
                                }
                                if ($current_user['id'] == $comment['Comment']['user_id'] || $current_user['Group']['id'] == 1) {
                                    echo $this->Form->postLink(__('Delete'), array('controller' => 'comments', 'action' => 'delete', $comment['Comment']['id'], '?' => array('projectId' => $project['Project']['id'], 'kind' => $project['Project']['kind'])), array('class' => 'btn btn-danger pull-right'), __('Are you sure you want to delete this comment & asset?', $comment['Comment']['id']));
                                } else {
                                    if ($current_user['id'] == $comment['Comment']['user_id'] || $current_user['Group']['id'] == 1) {
                                        echo $this->Form->postLink(__('Delete'), array('controller' => 'comments', 'action' => 'delete', $comment['Comment']['id'], '?' => array('projectId' => $project['Project']['id'], 'kind' => $project['Project']['kind'])), array('class' => 'btn btn-danger pull-right'), __('Are you sure you want to delete this comment?', $comment['Comment']['id']));
                                    }
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </li>
            <?php endforeach; ?>
            <li>
                <i class="fa fa-clock-o"></i>
            </li>

        </ul>

        <p>
            <?php
            echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
            ));
            ?>	</p>
        <div class="paging">
            <?php
            echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(array('separator' => ''));
            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
            ?>
        </div>

    </div>

<?php else: ?>
    <div class="box box-solid">
        <div class="box-body">
            <p class="message">                    
                There are currently no comments associated with this project :'(                  
            </p>
        </div>
    </div>
<?php endif;
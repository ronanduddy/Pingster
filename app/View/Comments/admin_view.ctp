<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'View Comment',
    'icon' => 'fa-comments',
));
?>

<dl>
    <dt><?php echo __('Id'); ?></dt>
    <dd>
        <?php echo h($comment['Comment']['id']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('User'); ?></dt>
    <dd>
        <?php echo $this->Html->link($comment['User']['id'], array('controller' => 'users', 'action' => 'view', $comment['User']['id'])); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Project'); ?></dt>
    <dd>
        <?php echo $this->Html->link($comment['Project']['title'], array('controller' => 'projects', 'action' => 'view', $comment['Project']['id'])); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Asset'); ?></dt>
    <dd>
        <?php echo $this->Html->link($comment['Asset']['id'], array('controller' => 'assets', 'action' => 'view', $comment['Asset']['id'])); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Comment'); ?></dt>
    <dd>
        <?php echo h($comment['Comment']['comment']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Modified'); ?></dt>
    <dd>
        <?php echo h($comment['Comment']['modified']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Created'); ?></dt>
    <dd>
        <?php echo h($comment['Comment']['created']); ?>
        &nbsp;
    </dd>
</dl>

<?php
echo $this->element('Admin/foot', array(
    'showPaginate' => false,
    'footLinks' => array(
        $this->Html->link('List Comments', array('controller' => 'Comments', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->postLink(__('Delete Comment'), array('action' => 'delete', $this->params['pass'][0]), array('class' => 'btn btn-danger btn-flat'), __('Are you sure you want to delete # %s?', $this->params['pass'][0])),
    )
));
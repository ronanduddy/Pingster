<?php

echo $this->element('Admin/head', array(
    'adminTitle' => 'Add Comment',
    'icon' => 'fa-comments',
));
echo $this->Form->create('Comment');
echo $this->Form->input('user_id', array(
    'type' => 'hidden',
    'value' => $current_user['id']
));
echo $this->Form->input('project_id');
echo $this->Form->input('asset_id');
echo $this->Form->input('comment');

echo $this->element('Admin/foot', array(
    'showPaginate' => false,
    'footLinks' => array(
        $this->Html->link('List Comments', array('controller' => 'Comments', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->submit('Add Comment', array(
            'class' => 'btn btn-primary btn-flat',
            'div' => false,
        )),
        $this->Form->end()
    )
));
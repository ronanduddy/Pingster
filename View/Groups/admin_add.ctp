<?php

echo $this->element('Admin/head', array(
    'adminTitle' => 'Add Group',
    'icon' => 'fa-lemon-o',
));

echo $this->Form->create('Group', array(
    'action' => 'add'
));

echo $this->Form->input('name');

echo $this->element('Admin/foot', array(
    'showPaginate' => false,
    'footLinks' => array(
        $this->Html->link('List Groups', array('controller' => 'Groups', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->submit('Add Group', array(
            'class' => 'btn btn-primary btn-flat',
            'div' => false,
        )),
        $this->Form->end()
    )
));
?>
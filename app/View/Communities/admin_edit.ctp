<?php

echo $this->element('Admin/head', array(
    'adminTitle' => 'Edit Community',
    'icon' => 'fa-globe',
));

// create form
echo $this->Form->create('Community');

echo $this->Form->input('id');
echo $this->Form->input('name');
echo $this->Form->input('Project');

echo $this->element('Admin/foot', array(
    'showPaginate' => false,
    'footLinks' => array(
        $this->Html->link('List Communities', array('controller' => 'Communities', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->submit('Edit Community', array(
            'class' => 'btn btn-primary btn-flat',
            'div' => false,
        )),
        $this->Form->end(),
    )
));

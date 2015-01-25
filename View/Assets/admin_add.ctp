<?php

echo $this->element('Admin/head', array(
    'adminTitle' => 'Add Asset',
    'icon' => 'fa-cloud',
));

echo $this->Form->create('Asset');

echo $this->Form->input('user_id');
echo $this->Form->input('asset');
echo $this->Form->input('asset_url');
echo $this->Form->input('asset_status');
echo $this->Form->input('Project');

echo $this->element('Admin/foot', array(
    'showPaginate' => false,
    'footLinks' => array(
        $this->Html->link('List Assets', array('controller' => 'Assets', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->submit('Add Asset', array(
            'class' => 'btn btn-primary btn-flat',
            'div' => false,
        )),
        $this->Form->end()
    )
));
?>
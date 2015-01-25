<?php

echo $this->element('Admin/head', array(
    'adminTitle' => 'Edit Asset',
    'icon' => 'fa-cloud',
));
?>
<div class="callout callout-warning">
    <h4>Note</h4>
    <p>Editing an asset has not been tested. For this reason, the 'Edit Asset' button below has been disabled.</p>
</div>
<?php
echo $this->Form->create('Asset');

echo $this->Form->input('id');
echo $this->Form->input('user_id');
echo $this->Form->input('asset');
echo $this->Form->input('asset_url');
echo $this->Form->input('asset_status');
echo $this->Form->input('Project');

echo $this->element('Admin/foot', array(
    'showPaginate' => false,
    'footLinks' => array(
        $this->Html->link('List Assets', array('controller' => 'Assets', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->submit('Edit Asset', array(
            'class' => 'btn btn-primary btn-flat disabled',
            'div' => false,
        )),
        $this->Form->end(),
    )
));
?>

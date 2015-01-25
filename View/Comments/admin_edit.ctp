<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'Edit Comment',
    'icon' => 'fa-comments',
));
?>
<div class="callout callout-warning">
    <h4>Known Issue</h4>
    <p>When editing a comment here, the system creates another record with the reflected edit (duplication).</p>
</div>
<?php
echo $this->Form->create('Comment');
echo $this->Form->input('user_id', array(
        // 'type' => 'hidden',
));
echo $this->Form->input('project_id');
echo $this->Form->input('asset_id', array(
        // 'type' => 'hidden',
));
echo $this->Form->input('comment');

echo $this->element('Admin/foot', array(
    'showPaginate' => false,
    'footLinks' => array(
        $this->Html->link('List Comments', array('controller' => 'Comments', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->submit('Edit Comment', array(
            'class' => 'btn btn-primary btn-flat',
            'div' => false,
        )),
        $this->Form->end(),
    )
));
?>

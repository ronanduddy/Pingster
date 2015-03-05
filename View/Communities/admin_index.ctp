<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'Communities',
    'icon' => 'fa-globe',
));
?>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th><?php echo $this->Paginator->sort('name'); ?></th>
                <th><?php echo $this->Paginator->sort('modified'); ?></th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($communities as $community): ?>
                <tr>
                    <td><?php echo h($community['Community']['id']); ?>&nbsp;</td>
                    <td><?php echo h($community['Community']['name']); ?>&nbsp;</td>
                    <td><?php echo h($community['Community']['modified']); ?>&nbsp;</td>
                    <td><?php echo h($community['Community']['created']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $community['Community']['id'])); ?>
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $community['Community']['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $community['Community']['id']), array(), __('Are you sure you want to delete # %s?', $community['Community']['id'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>  
<?php
echo $this->element('Admin/foot', array(
    'showPaginate' => true,
    'footLinks' => array(
        $this->Html->link(__('New Community'), array('action' => 'add'), array('class' => 'btn btn-primary btn-flat')),
    )
));

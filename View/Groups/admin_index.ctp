<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'Groups',
    'icon' => 'fa-lemon-o',
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
            <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?php echo h($group['Group']['id']); ?>&nbsp;</td>
                    <td><?php echo h($group['Group']['name']); ?>&nbsp;</td>
                    <td><?php echo h($group['Group']['modified']); ?>&nbsp;</td>
                    <td><?php echo h($group['Group']['created']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $group['Group']['id'])); ?>
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $group['Group']['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $group['Group']['id']), array(), __('Are you sure you want to delete # %s?', $group['Group']['id'])); ?>
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
        $this->Html->link(__('New Group'), array('action' => 'add'), array('class' => 'btn btn-primary btn-flat')),
    )
));
?>
<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'Assets',
    'icon' => 'fa-cloud',
));
?>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th><?php echo $this->Paginator->sort('user_id'); ?></th>
                <th><?php echo $this->Paginator->sort('asset'); ?></th>
                <th><?php echo $this->Paginator->sort('asset_url'); ?></th>
                <th><?php echo $this->Paginator->sort('asset_status'); ?></th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assets as $asset): ?>
                <tr>
                    <td><?php echo h($asset['Asset']['id']); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($asset['User']['id'], array('controller' => 'users', 'action' => 'view', $asset['User']['id'])); ?>
                    </td>
                    <td><?php echo h($asset['Asset']['asset']); ?>&nbsp;</td>
                    <td><?php echo h($asset['Asset']['asset_url']); ?>&nbsp;</td>
                    <td><?php echo h(Asset::statuses($asset['Asset']['asset_status'])); ?>&nbsp;</td>
                    <td><?php echo h($asset['Asset']['created']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $asset['Asset']['id'])); ?>
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $asset['Asset']['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $asset['Asset']['id']), array(), __('Are you sure you want to delete # %s?', $asset['Asset']['id'])); ?>
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
        $this->Html->link(__('New Asset'), array('action' => 'add'), array('class' => 'btn btn-primary btn-flat')),
    )
));

<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'Users',
    'icon' => 'fa-users',
));
?>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th><?php echo $this->Paginator->sort('group_id'); ?></th>
                <th><?php echo $this->Paginator->sort('email'); ?></th>
                <th><?php echo $this->Paginator->sort('username'); ?></th>
                <th><?php echo $this->Paginator->sort('age'); ?></th>
                <th><?php echo $this->Paginator->sort('ping_power'); ?></th>
                <th><?php echo $this->Paginator->sort('school'); ?></th>
                <th><?php echo $this->Paginator->sort('modified'); ?></th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo h($user['User']['id']); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
                    </td>
                    <td><?php echo h($user['User']['email']); ?>&nbsp;</td>
                    <td><?php echo h($user['User']['username']); ?>&nbsp;</td>
                    <td><?php echo h($user['User']['age']); ?>&nbsp;</td>
                    <td><?php echo h($user['User']['ping_power']); ?>&nbsp;</td>
                    <td><?php echo h($user['User']['school']); ?>&nbsp;</td>
                    <td><?php echo h($user['User']['modified']); ?>&nbsp;</td>
                    <td><?php echo h($user['User']['created']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])); ?>
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), array(), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
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
        $this->Html->link(__('New User'), array('action' => 'add'), array('class' => 'btn btn-primary btn-flat')),
    )
));
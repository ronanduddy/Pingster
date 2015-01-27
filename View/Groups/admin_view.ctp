<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'View Group',
    'icon' => 'fa-lemon-o',
));
?>
<dl>
    <dt><?php echo __('Id'); ?></dt>
    <dd>
        <?php echo h($group['Group']['id']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Name'); ?></dt>
    <dd>
        <?php echo h($group['Group']['name']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Modified'); ?></dt>
    <dd>
        <?php echo h($group['Group']['modified']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Created'); ?></dt>
    <dd>
        <?php echo h($group['Group']['created']); ?>
        &nbsp;
    </dd>
</dl>

<div class="related">
    <h3><?php echo __('Related Users'); ?></h3>
    <?php if (!empty($group['User'])): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <tr>
                    <th><?php echo __('Id'); ?></th>
                    <th><?php echo __('Group Id'); ?></th>
                    <th><?php echo __('Email'); ?></th>
                    <th><?php echo __('Username'); ?></th>
                    <th><?php echo __('Password'); ?></th>
                    <th><?php echo __('Modified'); ?></th>
                    <th><?php echo __('Created'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                <?php foreach ($group['User'] as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['group_id']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['password']; ?></td>
                        <td><?php echo $user['modified']; ?></td>
                        <td><?php echo $user['created']; ?></td>
                        <td class="actions">
                            <?php echo $this->Html->link(__('View'), array('controller' => 'users', 'action' => 'view', $user['id'])); ?>
                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?>
                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'users', 'action' => 'delete', $user['id']), array(), __('Are you sure you want to delete # %s?', $user['id'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>

<?php
echo $this->element('Admin/foot', array(
    'showPaginate' => false,
    'footLinks' => array(
        $this->Html->link('List Groups', array('controller' => 'Groups', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->postLink(__('Delete Group'), array('action' => 'delete', $this->params['pass'][0]), array('class' => 'btn btn-danger btn-flat'), __('Are you sure you want to delete # %s?', $this->params['pass'][0])),
    )
));
<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'View Asset',
    'icon' => 'fa-cloud',
));
?>
<dl>
    <dt><?php echo __('Id'); ?></dt>
    <dd>
        <?php echo h($asset['Asset']['id']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('User'); ?></dt>
    <dd>
        <?php echo $this->Html->link($asset['User']['id'], array('controller' => 'users', 'action' => 'view', $asset['User']['id'])); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Asset'); ?></dt>
    <dd>
        <?php echo h($asset['Asset']['asset']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Asset Url'); ?></dt>
    <dd>
        <?php echo h($asset['Asset']['asset_url']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Asset Status'); ?></dt>
    <dd>
        <?php echo h($asset['Asset']['asset_status']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Created'); ?></dt>
    <dd>
        <?php echo h($asset['Asset']['created']); ?>
        &nbsp;
    </dd>
</dl>

<div class="related">
    <h3><?php echo __('Related Comment'); ?></h3>
    <?php if (!empty($asset['Comment'])): ?>
        <dl>
            <dt><?php echo __('Id'); ?></dt>
            <dd>
                <?php echo $asset['Comment']['id']; ?>
                &nbsp;</dd>
            <dt><?php echo __('User Id'); ?></dt>
            <dd>
                <?php echo $asset['Comment']['user_id']; ?>
                &nbsp;</dd>
            <dt><?php echo __('Project Id'); ?></dt>
            <dd>
                <?php echo $asset['Comment']['project_id']; ?>
                &nbsp;</dd>
            <dt><?php echo __('Asset Id'); ?></dt>
            <dd>
                <?php echo $asset['Comment']['asset_id']; ?>
                &nbsp;</dd>
            <dt><?php echo __('Comment'); ?></dt>
            <dd>
                <?php echo $asset['Comment']['comment']; ?>
                &nbsp;</dd>
            <dt><?php echo __('Modified'); ?></dt>
            <dd>
                <?php echo $asset['Comment']['modified']; ?>
                &nbsp;</dd>
            <dt><?php echo __('Created'); ?></dt>
            <dd>
                <?php echo $asset['Comment']['created']; ?>
                &nbsp;</dd>
        </dl>
    <?php endif; ?>
    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('Edit Comment'), array('controller' => 'comments', 'action' => 'edit', $asset['Comment']['id'])); ?></li>
        </ul>
    </div>
</div>
<div class="related">
    <h3><?php echo __('Related Projects'); ?></h3>
    <?php if (!empty($asset['Project'])): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <tr>
                    <th><?php echo __('Id'); ?></th>
                    <th><?php echo __('Kind'); ?></th>
                    <th><?php echo __('Title'); ?></th>
                    <th><?php echo __('Description'); ?></th>
                    <th><?php echo __('Image'); ?></th>
                    <th><?php echo __('Image Url'); ?></th>
                    <th><?php echo __('Status'); ?></th>
                    <th><?php echo __('Modified'); ?></th>
                    <th><?php echo __('Created'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                <?php foreach ($asset['Project'] as $project): ?>
                    <tr>
                        <td><?php echo $project['id']; ?></td>
                        <td><?php echo $project['kind']; ?></td>
                        <td><?php echo $project['title']; ?></td>
                        <td><?php echo $project['description']; ?></td>
                        <td><?php echo $project['image']; ?></td>
                        <td><?php echo $project['image_url']; ?></td>
                        <td><?php echo $project['status']; ?></td>
                        <td><?php echo $project['modified']; ?></td>
                        <td><?php echo $project['created']; ?></td>
                        <td class="actions">
                            <?php echo $this->Html->link(__('View'), array('controller' => 'projects', 'action' => 'view', $project['id'])); ?>
                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'projects', 'action' => 'edit', $project['id'])); ?>
                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'projects', 'action' => 'delete', $project['id']), array(), __('Are you sure you want to delete # %s?', $project['id'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>

<?php
echo $this->element('Admin/foot', array(
    'showPaginate' => false,
    'footLinks' => array(
        $this->Html->link('List Assets', array('controller' => 'Assets', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->postLink(__('Delete Asset'), array('action' => 'delete', $this->params['pass'][0]), array('class' => 'btn btn-danger btn-flat'), __('Are you sure you want to delete # %s?', $this->params['pass'][0])),
    )
));
?>
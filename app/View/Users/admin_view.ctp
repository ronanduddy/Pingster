<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'View User',
    'icon' => 'fa-users',
));
?>
<dl>
    <dt><?php echo __('Id'); ?></dt>
    <dd>
        <?php echo h($user['User']['id']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Group'); ?></dt>
    <dd>
        <?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Email'); ?></dt>
    <dd>
        <?php echo h($user['User']['email']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Age'); ?></dt>
    <dd>
        <?php echo h($user['User']['age']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Ping Power'); ?></dt>
    <dd>
        <?php echo h($user['User']['ping_power']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('School'); ?></dt>
    <dd>
        <?php echo h($user['User']['school']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Username'); ?></dt>
    <dd>
        <?php echo h($user['User']['username']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Password'); ?></dt>
    <dd>
        <?php echo h($user['User']['password']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Modified'); ?></dt>
    <dd>
        <?php echo h($user['User']['modified']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Created'); ?></dt>
    <dd>
        <?php echo h($user['User']['created']); ?>
        &nbsp;
    </dd>
</dl>

<div class="related">
    <h3><?php echo __('Related Assets'); ?></h3>
    <?php if (!empty($user['Assets'])): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <tr>
                    <th><?php echo __('Id'); ?></th>
                    <th><?php echo __('User Id'); ?></th>
                    <th><?php echo __('Asset'); ?></th>
                    <th><?php echo __('Asset Url'); ?></th>
                    <th><?php echo __('Asset Status'); ?></th>
                    <th><?php echo __('Created'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                <?php foreach ($user['Assets'] as $assets): ?>
                    <tr>
                        <td><?php echo $assets['id']; ?></td>
                        <td><?php echo $assets['user_id']; ?></td>
                        <td><?php echo $assets['asset']; ?></td>
                        <td><?php echo $assets['asset_url']; ?></td>
                        <td><?php echo Asset::statuses($assets['asset_status']); ?></td>
                        <td><?php echo $assets['created']; ?></td>
                        <td class="actions">
                            <?php echo $this->Html->link(__('View'), array('controller' => 'assets', 'action' => 'view', $assets['id'])); ?>
                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'assets', 'action' => 'edit', $assets['id'])); ?>
                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'assets', 'action' => 'delete', $assets['id']), array(), __('Are you sure you want to delete # %s?', $assets['id'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Assets'), array('controller' => 'assets', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>

<div class="related">
    <h3><?php echo __('Related Comments'); ?></h3>
    <?php if (!empty($user['Comment'])): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <tr>
                    <th><?php echo __('Id'); ?></th>
                    <th><?php echo __('User Id'); ?></th>
                    <th><?php echo __('Project Id'); ?></th>
                    <th><?php echo __('Asset Id'); ?></th>
                    <th><?php echo __('Comment'); ?></th>
                    <th><?php echo __('Modified'); ?></th>
                    <th><?php echo __('Created'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                <?php foreach ($user['Comment'] as $comment): ?>
                    <tr>
                        <td><?php echo $comment['id']; ?></td>
                        <td><?php echo $comment['user_id']; ?></td>
                        <td><?php echo $comment['project_id']; ?></td>
                        <td><?php echo $comment['asset_id']; ?></td>
                        <td><?php echo $comment['comment']; ?></td>
                        <td><?php echo $comment['modified']; ?></td>
                        <td><?php echo $comment['created']; ?></td>
                        <td class="actions">
                            <?php echo $this->Html->link(__('View'), array('controller' => 'comments', 'action' => 'view', $comment['id'])); ?>
                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'comments', 'action' => 'edit', $comment['id'])); ?>
                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'comments', 'action' => 'delete', $comment['id']), array(), __('Are you sure you want to delete # %s?', $comment['id'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>

<div class="related">
    <h3><?php echo __('Related Projects Users'); ?></h3>
    <?php if (!empty($user['ProjectsUser'])): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <tr>
                    <th><?php echo __('Id'); ?></th>
                    <th><?php echo __('User Id'); ?></th>
                    <th><?php echo __('Project Id'); ?></th>
                    <th><?php echo __('User Role'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                <?php foreach ($user['ProjectsUser'] as $projectsUser): ?>
                    <tr>
                        <td><?php echo $projectsUser['id']; ?></td>
                        <td><?php echo $projectsUser['user_id']; ?></td>
                        <td><?php echo $projectsUser['project_id']; ?></td>
                        <td><?php echo $projectsUser['user_role']; ?></td>
                        <td class="actions">
                            <?php echo $this->Html->link(__('View'), array('controller' => 'projects_users', 'action' => 'view', $projectsUser['id'])); ?>
                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'projects_users', 'action' => 'edit', $projectsUser['id'])); ?>
                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'projects_users', 'action' => 'delete', $projectsUser['id']), array(), __('Are you sure you want to delete # %s?', $projectsUser['id'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Projects User'), array('controller' => 'projects_users', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>
<div class="related">
    <h3><?php echo __('Related Projects'); ?></h3>
    <?php if (!empty($user['Project'])): ?>
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
                <?php foreach ($user['Project'] as $project): ?>
                    <tr>
                        <td><?php echo $project['id']; ?></td>
                        <td><?php echo Project::kind($project['kind']); ?></td>
                        <td><?php echo $project['title']; ?></td>
                        <td><?php echo $project['description']; ?></td>
                        <td><?php echo $project['image']; ?></td>
                        <td><?php echo $project['image_url']; ?></td>
                        <td><?php echo Project::statuses($project['status']); ?></td>
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
        $this->Html->link('List Users', array('controller' => 'Users', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger btn-flat'), __('Are you sure you want to delete # %s?', $user['User']['id'])),
    )
));

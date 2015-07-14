<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'View Project',
    'icon' => 'fa-archive',
));
?>
<dl>
    <dt><?php echo __('Id'); ?></dt>
    <dd>
        <?php echo h($project['Project']['id']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Kind'); ?></dt>
    <dd>
        <?php echo h($project['Project']['kind']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Title'); ?></dt>
    <dd>
        <?php echo h($project['Project']['title']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Description'); ?></dt>
    <dd>
        <?php echo h($project['Project']['description']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Image'); ?></dt>
    <dd>
        <?php echo h($project['Project']['image']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Image Url'); ?></dt>
    <dd>
        <?php echo h($project['Project']['image_url']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Status'); ?></dt>
    <dd>
        <?php echo h($project['Project']['status']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Modified'); ?></dt>
    <dd>
        <?php echo h($project['Project']['modified']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Created'); ?></dt>
    <dd>
        <?php echo h($project['Project']['created']); ?>
        &nbsp;
    </dd>
</dl>

<div class="related">
    <h3><?php echo __('Related Comments'); ?></h3>
    <?php if (!empty($project['Comment'])): ?>
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
                <?php foreach ($project['Comment'] as $comment): ?>
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
    <?php if (!empty($project['ProjectsUser'])): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <tr>
                    <th><?php echo __('Id'); ?></th>
                    <th><?php echo __('User Id'); ?></th>
                    <th><?php echo __('Project Id'); ?></th>
                    <th><?php echo __('User Role'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                <?php foreach ($project['ProjectsUser'] as $projectsUser): ?>
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
    <h3><?php echo __('Related Assets'); ?></h3>
    <?php if (!empty($project['Asset'])): ?>
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
                <?php foreach ($project['Asset'] as $asset): ?>
                    <tr>
                        <td><?php echo $asset['id']; ?></td>
                        <td><?php echo $asset['user_id']; ?></td>
                        <td><?php echo $asset['asset']; ?></td>
                        <td><?php echo $asset['asset_url']; ?></td>
                        <td><?php echo $asset['asset_status']; ?></td>
                        <td><?php echo $asset['created']; ?></td>
                        <td class="actions">
                            <?php echo $this->Html->link(__('View'), array('controller' => 'assets', 'action' => 'view', $asset['id'])); ?>
                            <?php echo $this->Html->link(__('Edit'), array('controller' => 'assets', 'action' => 'edit', $asset['id'])); ?>
                            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'assets', 'action' => 'delete', $asset['id']), array(), __('Are you sure you want to delete # %s?', $asset['id'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Asset'), array('controller' => 'assets', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>

<div class="related">
    <h3><?php echo __('Related Users'); ?></h3>
    <?php if (!empty($project['User'])): ?>
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
                <?php foreach ($project['User'] as $user): ?>
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
        $this->Html->link('List Projects', array('controller' => 'Projects', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->postLink(__('Delete Project'), array('action' => 'delete', $this->params['pass'][0]), array('class' => 'btn btn-danger btn-flat'), __('Are you sure you want to delete # %s?', $this->params['pass'][0])),
    )
));

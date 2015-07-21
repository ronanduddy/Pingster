<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'View Community',
    'icon' => 'fa-globe',
));
?>
<dl>
    <dt><?php echo __('Id'); ?></dt>
    <dd>
        <?php echo h($community['Community']['id']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Name'); ?></dt>
    <dd>
        <?php echo h($community['Community']['name']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Modified'); ?></dt>
    <dd>
        <?php echo h($community['Community']['modified']); ?>
        &nbsp;
    </dd>
    <dt><?php echo __('Created'); ?></dt>
    <dd>
        <?php echo h($community['Community']['created']); ?>
        &nbsp;
    </dd>
</dl>

<div class="related">
    <h3><?php echo __('Related Projects'); ?></h3>
    <?php if (!empty($community['Project'])): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <tr>
                    <th><?php echo __('Id'); ?></th>
                    <th><?php echo __('Kind'); ?></th>
                    <th><?php echo __('Title'); ?></th>
                    <th><?php echo __('Description'); ?></th>
                    <th><?php echo __('Love'); ?></th>
                    <th><?php echo __('Image'); ?></th>
                    <th><?php echo __('Image Url'); ?></th>
                    <th><?php echo __('Status'); ?></th>
                    <th><?php echo __('Modified'); ?></th>
                    <th><?php echo __('Created'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                <?php foreach ($community['Project'] as $project): ?>
                    <tr>
                        <td><?php echo $project['id']; ?></td>
                        <td><?php echo Project::kinds($project['kind']); ?></td>
                        <td><?php echo $project['title']; ?></td>
                        <td><?php echo $project['description']; ?></td>
                        <td><?php echo $project['love']; ?></td>
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
        $this->Html->link('List Communities', array('controller' => 'Communities', 'action' => 'index'), array('class' => 'btn btn-default btn-flat')),
        $this->Form->postLink(__('Delete Communitiy'), array('action' => 'delete', $this->params['pass'][0]), array('class' => 'btn btn-danger btn-flat'), __('Are you sure you want to delete # %s?', $this->params['pass'][0])),
    )
));

<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'Comments',
    'icon' => 'fa-comments',
));
?>
<div class="callout callout-warning">
    <h4>Note</h4>
    <p>If a comment as a corresponding asset, it will not be deleted when deleting a comment. You would need to recall the asset's ID and remove it in the 'Assets' section (link to left).</p>
</div>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th><?php echo $this->Paginator->sort('user_id'); ?></th>
                <th><?php echo $this->Paginator->sort('project_id'); ?></th>
                <th><?php echo $this->Paginator->sort('asset_id'); ?></th>
                <th><?php echo $this->Paginator->sort('comment'); ?></th>
                <th><?php echo $this->Paginator->sort('modified'); ?></th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?php echo h($comment['Comment']['id']); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($comment['User']['id'], array('controller' => 'users', 'action' => 'view', $comment['User']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($comment['Project']['title'], array('controller' => 'projects', 'action' => 'view', $comment['Project']['id'])); ?>
                    </td>
                    <td>
                        <?php echo $this->Html->link($comment['Asset']['id'], array('controller' => 'assets', 'action' => 'view', $comment['Asset']['id'])); ?>
                    </td>
                    <td><?php echo h($comment['Comment']['comment']); ?>&nbsp;</td>
                    <td><?php echo h($comment['Comment']['modified']); ?>&nbsp;</td>
                    <td><?php echo h($comment['Comment']['created']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $comment['Comment']['id'])); ?>
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $comment['Comment']['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $comment['Comment']['id']), array(), __('Are you sure you want to delete # %s?', $comment['Comment']['id'])); ?>
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
        $this->Html->link(__('New Comment'), array('action' => 'add'), array('class' => 'btn btn-primary btn-flat')),
    )
));
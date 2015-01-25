<?php
echo $this->element('Admin/head', array(
    'adminTitle' => 'Projects',
    'icon' => 'fa-archive',
));
?>
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th><?php echo $this->Paginator->sort('kind'); ?></th>
                <th><?php echo $this->Paginator->sort('title'); ?></th>
                <th><?php echo $this->Paginator->sort('description'); ?></th>
                <th><?php echo $this->Paginator->sort('image'); ?></th>
                <th><?php echo $this->Paginator->sort('image_url'); ?></th>
                <th><?php echo $this->Paginator->sort('status'); ?></th>
                <th><?php echo $this->Paginator->sort('modified'); ?></th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?php echo h($project['Project']['id']); ?>&nbsp;</td>
                    <td><?php echo h($project['Project']['kind']); ?>&nbsp;</td>
                    <td><?php echo h($project['Project']['title']); ?>&nbsp;</td>
                    <td><?php echo h($project['Project']['description']); ?>&nbsp;</td>
                    <td><?php echo h($project['Project']['image']); ?>&nbsp;</td>
                    <td><?php echo h($project['Project']['image_url']); ?>&nbsp;</td>
                    <td><?php echo h($project['Project']['status']); ?>&nbsp;</td>
                    <td><?php echo h($project['Project']['modified']); ?>&nbsp;</td>
                    <td><?php echo h($project['Project']['created']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $project['Project']['id'])); ?>
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $project['Project']['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $project['Project']['id']), array(), __('Are you sure you want to delete # %s?', $project['Project']['id'])); ?>
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
        $this->Html->link(__('New Project'), array('action' => 'add'), array('class' => 'btn btn-primary btn-flat')),
    )
));
?>
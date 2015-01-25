<div class="assetsProjects index">
	<h2><?php echo __('Assets Projects'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('asset_id'); ?></th>
			<th><?php echo $this->Paginator->sort('project_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($assetsProjects as $assetsProject): ?>
	<tr>
		<td><?php echo h($assetsProject['AssetsProject']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($assetsProject['Asset']['id'], array('controller' => 'assets', 'action' => 'view', $assetsProject['Asset']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($assetsProject['Project']['title'], array('controller' => 'projects', 'action' => 'view', $assetsProject['Project']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $assetsProject['AssetsProject']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $assetsProject['AssetsProject']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $assetsProject['AssetsProject']['id']), array(), __('Are you sure you want to delete # %s?', $assetsProject['AssetsProject']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Assets Project'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Assets'), array('controller' => 'assets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Asset'), array('controller' => 'assets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
	</ul>
</div>

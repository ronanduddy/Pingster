<div class="communitiesProjects index">
	<h2><?php echo __('Communities Projects'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('project_id'); ?></th>
			<th><?php echo $this->Paginator->sort('community_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($communitiesProjects as $communitiesProject): ?>
	<tr>
		<td><?php echo h($communitiesProject['CommunitiesProject']['id']); ?>&nbsp;</td>
		<td><?php echo h($communitiesProject['CommunitiesProject']['project_id']); ?>&nbsp;</td>
		<td><?php echo h($communitiesProject['CommunitiesProject']['community_id']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $communitiesProject['CommunitiesProject']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $communitiesProject['CommunitiesProject']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $communitiesProject['CommunitiesProject']['id']), array(), __('Are you sure you want to delete # %s?', $communitiesProject['CommunitiesProject']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Communities Project'), array('action' => 'add')); ?></li>
	</ul>
</div>

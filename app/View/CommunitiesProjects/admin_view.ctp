<div class="communitiesProjects view">
<h2><?php echo __('Communities Project'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($communitiesProject['CommunitiesProject']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Project Id'); ?></dt>
		<dd>
			<?php echo h($communitiesProject['CommunitiesProject']['project_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Community Id'); ?></dt>
		<dd>
			<?php echo h($communitiesProject['CommunitiesProject']['community_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Communities Project'), array('action' => 'edit', $communitiesProject['CommunitiesProject']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Communities Project'), array('action' => 'delete', $communitiesProject['CommunitiesProject']['id']), array(), __('Are you sure you want to delete # %s?', $communitiesProject['CommunitiesProject']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Communities Projects'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Communities Project'), array('action' => 'add')); ?> </li>
	</ul>
</div>

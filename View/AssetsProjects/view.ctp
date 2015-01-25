<div class="assetsProjects view">
<h2><?php echo __('Assets Project'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($assetsProject['AssetsProject']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Asset'); ?></dt>
		<dd>
			<?php echo $this->Html->link($assetsProject['Asset']['id'], array('controller' => 'assets', 'action' => 'view', $assetsProject['Asset']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Project'); ?></dt>
		<dd>
			<?php echo $this->Html->link($assetsProject['Project']['title'], array('controller' => 'projects', 'action' => 'view', $assetsProject['Project']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Assets Project'), array('action' => 'edit', $assetsProject['AssetsProject']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Assets Project'), array('action' => 'delete', $assetsProject['AssetsProject']['id']), array(), __('Are you sure you want to delete # %s?', $assetsProject['AssetsProject']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Assets Projects'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Assets Project'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Assets'), array('controller' => 'assets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Asset'), array('controller' => 'assets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
	</ul>
</div>

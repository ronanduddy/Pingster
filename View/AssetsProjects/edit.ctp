<div class="assetsProjects form">
<?php echo $this->Form->create('AssetsProject'); ?>
	<fieldset>
		<legend><?php echo __('Edit Assets Project'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('asset_id');
		echo $this->Form->input('project_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('AssetsProject.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('AssetsProject.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Assets Projects'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Assets'), array('controller' => 'assets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Asset'), array('controller' => 'assets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
	</ul>
</div>

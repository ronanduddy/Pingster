<div class="communitiesProjects form">
<?php echo $this->Form->create('CommunitiesProject'); ?>
	<fieldset>
		<legend><?php echo __('Edit Communities Project'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('project_id');
		echo $this->Form->input('community_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CommunitiesProject.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('CommunitiesProject.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Communities Projects'), array('action' => 'index')); ?></li>
	</ul>
</div>

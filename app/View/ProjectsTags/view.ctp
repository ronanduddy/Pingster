<div class="projectsTags view">
<h2><?php echo __('Projects Tag'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($projectsTag['ProjectsTag']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tag'); ?></dt>
		<dd>
			<?php echo $this->Html->link($projectsTag['Tag']['id'], array('controller' => 'tags', 'action' => 'view', $projectsTag['Tag']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Project'); ?></dt>
		<dd>
			<?php echo $this->Html->link($projectsTag['Project']['title'], array('controller' => 'projects', 'action' => 'view', $projectsTag['Project']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Projects Tag'), array('action' => 'edit', $projectsTag['ProjectsTag']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Projects Tag'), array('action' => 'delete', $projectsTag['ProjectsTag']['id']), array(), __('Are you sure you want to delete # %s?', $projectsTag['ProjectsTag']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects Tags'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Projects Tag'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tags'), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tag'), array('controller' => 'tags', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
	</ul>
</div>

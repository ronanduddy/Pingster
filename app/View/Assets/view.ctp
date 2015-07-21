<div class="assets view">
<h2><?php echo __('Asset'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($asset['Asset']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($asset['User']['id'], array('controller' => 'users', 'action' => 'view', $asset['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Asset'); ?></dt>
		<dd>
			<?php echo h($asset['Asset']['asset']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Asset Url'); ?></dt>
		<dd>
			<?php echo h($asset['Asset']['asset_url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Asset Status'); ?></dt>
		<dd>
			<?php echo h(Asset::statuses($asset['Asset']['asset_status'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($asset['Asset']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Asset'), array('action' => 'edit', $asset['Asset']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Asset'), array('action' => 'delete', $asset['Asset']['id']), array(), __('Are you sure you want to delete # %s?', $asset['Asset']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Assets'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Asset'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Activities'), array('controller' => 'activities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Activity'), array('controller' => 'activities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Comments'), array('controller' => 'comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comment'), array('controller' => 'comments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Projects'), array('controller' => 'projects', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
	</ul>
</div>
	<div class="related">
		<h3><?php echo __('Related Activities'); ?></h3>
	<?php if (!empty($asset['Activity'])): ?>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
		<dd>
	<?php echo $asset['Activity']['id']; ?>
&nbsp;</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
	<?php echo $asset['Activity']['user_id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Asset Id'); ?></dt>
		<dd>
	<?php echo $asset['Activity']['asset_id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Project Id'); ?></dt>
		<dd>
	<?php echo $asset['Activity']['project_id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Action'); ?></dt>
		<dd>
	<?php echo $asset['Activity']['action']; ?>
&nbsp;</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
	<?php echo $asset['Activity']['created']; ?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit Activity'), array('controller' => 'activities', 'action' => 'edit', $asset['Activity']['id'])); ?></li>
			</ul>
		</div>
	</div>
		<div class="related">
		<h3><?php echo __('Related Comments'); ?></h3>
	<?php if (!empty($asset['Comment'])): ?>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
		<dd>
	<?php echo $asset['Comment']['id']; ?>
&nbsp;</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
	<?php echo $asset['Comment']['user_id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Project Id'); ?></dt>
		<dd>
	<?php echo $asset['Comment']['project_id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Asset Id'); ?></dt>
		<dd>
	<?php echo $asset['Comment']['asset_id']; ?>
&nbsp;</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
	<?php echo $asset['Comment']['comment']; ?>
&nbsp;</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
	<?php echo $asset['Comment']['modified']; ?>
&nbsp;</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
	<?php echo $asset['Comment']['created']; ?>
&nbsp;</dd>
		</dl>
	<?php endif; ?>
		<div class="actions">
			<ul>
				<li><?php echo $this->Html->link(__('Edit Comment'), array('controller' => 'comments', 'action' => 'edit', $asset['Comment']['id'])); ?></li>
			</ul>
		</div>
	</div>
	<div class="related">
	<h3><?php echo __('Related Projects'); ?></h3>
	<?php if (!empty($asset['Project'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Kind'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Image'); ?></th>
		<th><?php echo __('Image Url'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($asset['Project'] as $project): ?>
		<tr>
			<td><?php echo $project['id']; ?></td>
			<td><?php echo Project::kinds($project['kind']); ?></td>
			<td><?php echo $project['title']; ?></td>
			<td><?php echo $project['description']; ?></td>
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
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Project'), array('controller' => 'projects', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

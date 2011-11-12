<div class="events form">
<?php echo $this->Form->create('Event');?>
	<fieldset>
		<legend><?php __('Edit Event'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('event_status_id');
		echo $this->Form->input('hash');
		echo $this->Form->input('job_id');
		echo $this->Form->input('message');
		echo $this->Form->input('success');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Event.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Event.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Events', true), array('action' => 'index'));?></li>
	</ul>
</div>
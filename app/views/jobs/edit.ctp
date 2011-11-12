<h2>Edit Job</h2>

<div class="jobs form">
<?php echo $this->Form->create('Job');?>
	<fieldset class="default">
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('subject');
		echo $this->Form->input('from');
		echo $this->Form->input('start');
		echo $this->Form->input('end');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Update Job', true));?>
<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Job.id')), array('class' => 'button'), sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Job.name'))); ?>
</div>
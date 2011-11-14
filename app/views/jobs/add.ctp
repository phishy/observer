<script>
$(function(){
	$('#JobFreq').change(function(){
		freq = $(this).find(':selected').val();
		if (freq) {
			$('#rrule').show();
		} else {
			$('#rrule').hide();
		}
	});
	$('#EventAction0EventStatusId').change(function(){
		$('#EventAction0Email').focus();
	});
});
</script>

<?php print $this->element('menu') ?>

<h2>Would you like to define a job?</h2>

<?php echo $this->Form->create('Job');?>
	<fieldset class="default">
		<legend>Job Information</legend>
		<?php echo $this->Form->input('name', array('autofocus' => 'autofocus', 'size' => 100)); ?>
		<?php echo $this->Form->input('subject', array('size' => 100));?>
		<?php echo $this->Form->input('from', array('size' => 50));?>
		<?php echo $this->Form->input('start', array('label' => 'When do you expect the email?'));?>
		<div class="input">
			<label>How late can it be?</label>
			<?php print $form->select('interval', range(0, 30)) ?>
			<?php print $form->select('metric', array('minutes' => 'minutes', 'hours' => 'hours'), 'minutes') ?>
		</div>
		<?php echo $this->Form->input('freq', array('label' => 'Frequency', 
			'options' => array('' => 'Once', 'hourly' => 'Hourly', 'daily' => 'Daily', 'weekly' => 'Weekly')))
		?>
	
		<div id="rrule" style="display:none">
			<?php print $this->Form->input('end', array('empty' => true, 'label' => 'Until')) ?>
		</div>
	
		<?php print $form->input('description') ?>
	</fieldset>
	
		<!-- <fieldset class="default">
			<legend>Inspect Correspondence</legend>
			<?php print $form->input('whitecheck', array('label' => 'Regular expression to test for success')) ?>
			<?php print $form->input('blackcheck', array('label' => 'Regular expression to test for failure')) ?>
		</fieldset> -->

		<fieldset class="default">
			<legend>Notification Options</legend>
			On&nbsp;
			<?php print $form->select('EventAction.0.event_status_id', $event_statuses) ?>
			send email to&nbsp;
			<?php print $form->text('EventAction.0.email') ?>
		</fieldset>
<?php echo $this->Form->end(__('Add Job', true));?>
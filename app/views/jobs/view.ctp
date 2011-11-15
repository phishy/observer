<?php print $this->element('menu') ?>

<h2><?php print $job['Job']['name']?> Job</h2>

<fieldset class="default">
	<legend>Job Details</legend>
<table>
	<tr>
		<td>Job</td>
		<td><?php print $job['Job']['name']?></td>
	</tr>
	<tr>
		<td>Subject</td>
		<td><?php print $job['Job']['subject']?></td>
	</tr>
	<tr>
		<td>From</td>
		<td><?php print $job['Job']['from']?></td>
	</tr>
	<tr>
		<td>Start</td>
		<td><?php print date('F d, Y g:i A', strtotime($job['Job']['time_start'])) ?></td>
	</tr>
</table>
</fieldset>

<fieldset class="default">
	<legend>Event Log</legend>
	<table>
		<tr>
			<th>Status</th>
			<th>Message</th>
			<th>Received</th>
		</tr>
		<?php foreach ($job['Job']['Event'] as $event): ?>
		<tr>
			<td><?php print $event['event_status_id']?></td>
			<td><?php print $event['message']?></td>
			<td><?php print $event['created']?></td>
		</tr>
		<?php endforeach ?>
	</table>
</fieldset>
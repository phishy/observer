<script>
$(function worker(){
	$.ajax({
		url: '<?php print Router::url('/jobs/pollEmail') ?>', 
		success: function(data) {
			$('#incoming').fadeOut().html(data).fadeIn();
		},
		complete: function() {
			setTimeout(worker, 5000);
		}
	});
});
$(function(){
	$('#tabs').tabs({
		cookie: {
			// store cookie for a day, without, it would be a session cookie
			expires: 1
		}
	});
});
</script>

<?php print $this->element('menu') ?>

<h2>Jobs Dashboard for <?php print date('F d, Y')?></h2>

<div id="tabs">
	<ul>
		<li><a href="#queue">Today's Job Queue</a></li>
		<li><a href="#incoming">Incoming Email</a></li>
	</ul>
	<div id="queue">
		<p>
			<table>
				<tr>
					<th>Status</th>
					<th>Time Expected</th>
					<th>Job Name</th>
					<th>Subject</th>
					<th>From</th>
					<th>Actions</th>
				</tr>
			<?php foreach ($jobs as $j): ?>
				<?php $bgcolor = (strtotime($j['Job']['time_start']) > time()) ? 'red' : 'green' ?>
				<?php
					$current = array_pop($j['Job']['Event']);
					switch ($current['event_status_id']) {
						case EventStatus::Success:
							$color = 'green';
							$status = 'success';
							break;
						case EventStatus::Failure:
							$color = 'red';
							$status = 'failure';
							break;
						case EventStatus::Duplicate:
							$color = 'orange';
							$status = 'duplicate';
							break;
						case EventStatus::Late:
							$color = 'maroon';
							$status = 'late';
							break;
						default:
							$color = 'yellow';
							$status = 'waiting';
					}
				?>
				<tr>
					<td style="background-color: <?php print $color ?>"><?php print $status ?></td>
					<td>
						<?php print date('g:i A', strtotime($j['Job']['time_start'])) ?> - 
						<?php print date('g:i A', strtotime($j['Job']['time_start'] . "+ {$j['Job']['tolerance']}")) ?>
					</td>
					<td><?php print $j['Job']['name']?></td>
					<td><?php print $j['Job']['subject']?></td>
					<td><?php print $j['Job']['from']?></td>
					<td>
						<?php print $html->link('View', '/jobs/view/' . $j['Job']['hash'], array('class' => 'button')) ?>
					</td>
				</tr>
			<?php endforeach ?>
			</table>
		</p>
	</div>
	<div id="incoming">
	</div>
</div>
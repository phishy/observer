<p>
	<table>
		<tr>
			<th>From</th>
			<th>Subject</th>
			<th>Received</th>
			<th>Actions</th>
		</tr>
		<?php foreach($emails as $e): ?>
		<tr>
			<td><?php print $e['Email']['from']?></td>
			<td><?php print $e['Email']['subject']?></td>
			<td><?php print date('M d, Y H:i:s', strtotime($e['Email']['created'])) ?></td>
			<td>
				<?php print $html->link('View', '/emails/view/'.$e['Email']['id'], array('class' => 'button')) ?>
				<?php print $html->link('Observe', '/jobs/add/email:' . $e['Email']['id'],  array('class' => 'button')) ?>
				<?php print $html->link('Delete', '/emails/delete/' . $e['Email']['id'],  array('class' => 'button')) ?>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
</p>
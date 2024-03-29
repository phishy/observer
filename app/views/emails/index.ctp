<div class="emails index">
	<h2><?php __('Emails');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('subject');?></th>
			<th><?php echo $this->Paginator->sort('body');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($emails as $email):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $email['Email']['id']; ?>&nbsp;</td>
		<td><?php echo $email['Email']['subject']; ?>&nbsp;</td>
		<td><?php echo $email['Email']['body']; ?>&nbsp;</td>
		<td><?php echo $email['Email']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $email['Email']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $email['Email']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $email['Email']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $email['Email']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Email', true), array('action' => 'add')); ?></li>
	</ul>
</div>
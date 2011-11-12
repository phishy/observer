<?php print $this->element('menu') ?>

<h2><?php __('Jobs');?></h2>
	
<div class="jobs index">
	
	<?php echo $this->Html->link(__('New Job', true), array('action' => 'add'), array('class' => 'button')); ?><br /><br />
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('subject');?></th>
			<th><?php echo $this->Paginator->sort('from');?></th>
			<th><?php echo $this->Paginator->sort('owner_email');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($jobs as $job):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $job['Job']['name']; ?>&nbsp;</td>
		<td><?php echo $job['Job']['subject']; ?>&nbsp;</td>
		<td><?php echo $job['Job']['from']; ?>&nbsp;</td>
		<td><?php echo $job['Job']['owner_email']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $job['Job']['id']), array('class' => 'button')); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $job['Job']['id']), array('class' => 'button')); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $job['Job']['id']), array('class' => 'button'), sprintf(__('Are you sure you want to delete %s?', true), $job['Job']['name'])); ?>
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
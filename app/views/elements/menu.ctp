<style>
#instructions {
	background-color: #DDF4FB;
	padding: 20px;
	margin-bottom: 10px;
}
</style>

<div id="instructions">
If you would like to start tracking jobs immediately, forward your cron email to <h3><?php print $observer_email ?></h3>
</div>

<?php print $html->link('Dashboard', '/jobs/dashboard', array('class' => 'button')) ?>
<?php print $html->link('Add Job', '/jobs/add', array('class' => 'button')) ?>
<?php print $html->link('View Jobs', '/jobs', array('class' => 'button')) ?>
<?php print $html->link('Help', '/jobs/help', array('class' => 'button')) ?>
<?php print $html->link('Logout', '/users/logout', array('class' => 'button')) ?>
<br /><br />
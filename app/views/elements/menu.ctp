<style>
#instructions {
	background-color: #DDF4FB;
	padding: 20px;
	margin-bottom: 10px;
}
</style>

<div id="instructions">
To begin, send email to the system via <h3><?php print $observer_email ?></h3> When the email starts rolling
	in, you can start to be more specific about the jobs you define.
</div>

<?php print $html->link('Dashboard', '/jobs/dashboard', array('class' => 'button')) ?>
<?php print $html->link('Add Job', '/jobs/add', array('class' => 'button')) ?>
<?php print $html->link('View Jobs', '/jobs', array('class' => 'button')) ?>
<?php print $html->link('Help', '/jobs/help', array('class' => 'button')) ?>
<?php print $html->link('Logout', '/users/logout', array('class' => 'button')) ?>
<br /><br />
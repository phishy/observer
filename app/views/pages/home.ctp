<style>
#welcome {
/*	width: 45%;
	height: 200px;
	float: left;*/
	border: 1px solid #CCCCCC;
	padding: 10px;
	margin-right: 20px;
	margin-bottom: 10px;
}
#login {
	width: 520px;
	height: 200px;
	float: left;
	margin: 0 auto;
	border: 1px solid #CCCCCC;
	padding: 10px;
	margin-right: 20px;
}
#signup {
	width: 476px;
	height: 200px;
	float: left;
	margin: 0 auto;
	border: 1px solid #CCCCCC;
	padding: 10px;
}
#analogy {
	font-size: 20px;
	padding: 20px;
}
</style>
<div id="welcome">
	<h2>Solve your cron email problems.</h2>
	<p>Reviewing cron messages manually? Yeah, stop doing that.</p>
	<p>Every administrator or developer receives an email from cron at some point. Why? To determine whether or
		not a timed job was a success or failure. You could easily send emails to determine when a job was successful, but what
		if a job does not run? You would have to determine that you were missing that email. We can help.</p>
		
	<div id="analogy">"A lot of people use cron jobs as canaries in the mine, looking when the mail arrived to see if the canary is dead. The problem is, sometimes a cat steals the canary, and it's harder to notice something that's just not there." <br />- <b>Paul Reinheimer</b></div>
</div>
<div id="login">
	<h2>Login</h2>
	<?php print $form->create('User', array('url' => '/users/login')) ?>
	<?php print $form->input('email', array('autofocus' => 'autofocus')) ?>
	<?php print $form->input('password') ?>
	<?php print $form->end('Login') ?>
	
	<p><?php print $this->Html->link('Would you like to create an account?', '/users/signup') ?></p>
</div>
<div id="signup">
	<h2>Signup</h2>
	<?php print $form->create('User', array('url' => '/users/signup')) ?>
	<?php print $form->input('email') ?>
	<?php print $form->input('password') ?>
	<?php print $form->end('Sign Up') ?>
</div>
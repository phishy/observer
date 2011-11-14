<link href='http://fonts.googleapis.com/css?family=Petrona|Love+Ya+Like+A+Sister|Actor' rel='stylesheet' type='text/css'>
<style>
#welcome {
/*	width: 45%;
	height: 200px;
	float: left;*/
	padding: 10px;
	margin-bottom: 5px;
	font-family: 'Actor', sans-serif;
	background-color: #C6EDF9;
}
#login {
	width: 520px;
	height: 220px;
	float: left;
	margin: 0 auto;
	padding: 10px;
	margin-right: 20px;
	border: 1px solid #CCCCCC;
}
#signup {
	width: 495px;
	height: 220px;
	float: left;
	margin: 0 auto;
	border: 1px solid #CCCCCC;
	padding: 10px;
}
#analogy {
	font-family: 'Actor', sans-serif;
	font-size: 15px;
	padding: 15px;
	background-color: #DDF4FB;
	margin: 5px 0px 10px 0px;
}
#analogy h2 {
	margin: 0;
}
#tagline {
	width: 49%;
	float: left;
	height: 100%;
	margin-top: 20px;
}
#quote {
	width: 49%;
	float: left;
}
</style>

<div id="analogy">
	<div id="tagline"><h2>Solve your cron email problems.</h2></div>
	<div id="quote">"A lot of people use cron jobs as canaries in the mine, looking when the mail arrived to see if the canary is dead. The problem is, sometimes a cat steals the canary, and it's harder to notice something that's just not there."<br /><b>Paul Reinheimer of WonderProxy.com</b></div><br clear="all">
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
	<?php print $form->input('password_confirm', array('label' => 'Confirm password', 'type' => 'password')) ?>
	<?php print $form->end('Sign Up') ?>
</div>
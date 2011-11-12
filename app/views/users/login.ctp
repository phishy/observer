<div id="login">
	<h2>Login</h2>
	<?php print $form->create('User', array('url' => '/users/login')) ?>
	<?php print $form->input('email', array('autofocus' => 'autofocus')) ?>
	<?php print $form->input('password') ?>
	<?php print $form->end('Sign Up') ?>
	
	<?php print $this->Html->link('Would you like to create an account?', '/users/signup') ?>
</div>
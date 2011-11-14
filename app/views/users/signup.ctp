<div id="signup">
	<h2>Signup</h2>
	<?php print $form->create('User', array('url' => '/users/signup')) ?>
	<?php print $form->input('email', array('autofocus' => 'autofocus')) ?>
	<?php print $form->input('password') ?>
	<?php print $form->input('password_confirm', array('label' => 'Confirm password', 'type' => 'password')) ?>
	<?php print $form->end('Sign Up') ?>
</div>
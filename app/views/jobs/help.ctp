<?php print $this->element('menu') ?>

<h2>Job Observer Documentation</h2>
<p>This is the documentation for the job observer system.</p>

<h3>Event Triggers</h3>
<p>These are the conditions in which the system will create an event log entry.</p>
<ul>
	<li>email was never received</li>
	<li>email is late</li>
	<li>email comes on time</li>
	<li>email is over duplicate limit</li>
</ul>
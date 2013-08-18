<?php

require('Gentleform/gentleform.php');
$form = new GentleForm;

$form->addErrors(array(
	'field' => 'Just an error message.'
));

$form->addValues(array(
	'field' => 'info@example.org',
	'bio' => 'Users biography...'
));

echo $form->create('/url');
	echo $form->input('field');
	echo $form->textarea('bio');
echo $form->end('Submit');
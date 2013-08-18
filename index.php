<?php

require('gentleform.php');
$form = new GentleForm;

$form->addErrors(array(
	'field' => 'Just an error message.',
	'test' => 'Error message'
));

$form->addValues(array(
	'field' => 'andrew@andrewhathaway.net',
	'test' => 'This is the users bio text'
));

echo $form->create('/url');
	echo $form->input('field', 'text');
	echo $form->textarea('test');
echo $form->end('Submit');
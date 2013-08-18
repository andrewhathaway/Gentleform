<?php

require('Gentleform/gentleform.php');
$form = new GentleForm;

$form->addErrors(array(
	'field' => 'Just an error message.',
	'test' => 'Error message'
));

$form->addValues(array(
	'field' => 'andrew@andrewhathaway.net'
));

echo $form->create('/url');
	echo $form->input('field');
	echo $form->textarea('test');
echo $form->end('Submit');
<?php

require('form_master.php');

$form = new FormMaster;

$form->addErrors(array(
	'field' => 'Just an error message.'
));

echo $form->create('/url');

	echo $form->input('field', 'text');

echo $form->end('Submit');
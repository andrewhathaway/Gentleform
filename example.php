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

	echo $form->input('field', 'text', array(
		'label' => array(
			'text' => 'hahahah lolo',
			'class' => 'test'
		)
	));

	echo $form->input('auto_label');

	echo $form->input('no_label', 'text', array(
		'label' => false
	));

	echo $form->input('custom_text_label', 'text', array(
		'label' => array(
			'text' => 'This label should have custom text!'
		)
	));

	echo $form->textarea('bio');

	echo $form->option('category', array(
		'test' => 'hahahah'
	));

	echo $form->submit('Submit it', array('class' => 'button'));

echo $form->end();
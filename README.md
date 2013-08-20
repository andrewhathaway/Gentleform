Gentleform
==========

Forms like a gentleman in PHP.

Whilst working on [Blogcase](http://blogcase.co.uk), I wanted a nice form library to save me from the hell of dirty markup and code. I had disgusting if's and echo's here there an everywhere to print values and custom errors. No other nice libraries existed, that game me the simplicity and style that I wanted when creating the forms for Blogcase. So I created Gentleforms, a gentlemanly way of doing forms in PHP.

##TODO
- Support for radio buttons, checkboxes and select menus
- Rewrite the prepare_label function, it's not nice
- Support for other form input types etc
- Refactor, rewrite, fix

##Documentation
Gentleforms is easy to use. Start by:

```PHP
	require('gentleform.php');
	$form = new Gentleform;
```

####create($url, $method='post', $params = array())
This function creates a form with the URL given, the method and then any params are converted in to attributes.

```PHP
echo $form->create('/login', 'post', array(
	'class' => 'nice-form'
));
```

####end($text = 'Submit', $params = array())
Ends a form. Automatically creates a submit button with the text and parameters passed. This behaviour can be stopped by passing $text as false. This function also clears out the stored values and errors.

```PHP
echo $form->end(false); //</form>
echo $form->end('Roll with it', $params);
```


##Helping
Feel free to help out and submit pull requests! Also feel free to give feedback and tweet me on your wanting to ask questions.

[@andrewhathaway](http://twitter.com/andrewhathaway)
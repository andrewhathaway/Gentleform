Gentleform
==========

Forms like a gentleman in PHP.

Whilst working on [Blogcase](http://blogcase.co.uk), I wanted a nice form library to save me from the hell of dirty markup and code. I had disgusting if's and echo's here there an everywhere to print values and custom errors. No other nice libraries existed, that game me the simplicity and style that I wanted when creating the forms for Blogcase. So I created Gentleforms, a gentlemanly way of doing forms in PHP.

##TODO
- Support for radio buttons, checkboxes and select menus
- Rewrite the prepare_label function, it's not nice
- Support for other form input types etc
- Refactor, rewrite, fix
- Make how errors are printed customisable

##Documentation
Gentleforms is easy to use. Remember that form parameters get converted in to attributes. Start by:

```PHP
require('gentleform.php');
$form = new Gentleform;
```

####Configuration
Labels will automatically be created for inputs and textareas, the text will be a humanized version of the ```name``` attribute. This can be turned off by doing the following:

```PHP
$this->auto_label = false;
```

#####Configuring labels
When using ```input()``` or ```textarea()``` you can pass a ```label``` item in to the $params array. Some examples are:

```PHP
//Will create a label with "Your Name" contents
echo $this->input('your_name');

//Will not create a label
echo $this->input('your_name', 'text, array('label' => false));

//Will create a label with "Your Name Please!" contents
echo $this->input('your_name', 'text, array('label' => 'Your Name Please!'));

//Creates the lable with text "Enter your name", with the class "margin-bottom" and the for attribute of "your_name"
echo $this->input('your_name', 'text, array('label' => array(
	'text' => 'Enter your name',
	'class' => 'margin-bottom',
	'for' => 'your_name'
)));
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

####submit($text = 'Submit', $params = array())
Creates a submit button, with the text and params supplied.

```PHP
echo $form->submit('Button', $params);
```

####input($name, $type = 'text', $params = array())
Creates an input with the name, type and params given.

```PHP
echo $form->input('first_name', 'text', array(
	'class' => 'full'
));
```

####textarea($name, $params = array())
Creates a textarea with the name and params given.

```PHP
echo $form->textarea('user_bio', array(
	'class' => 'big-box'
));
```

####label($text, $params = array())
Manually create a label with the text and params passed.

```PHP
echo $form->label('User Biography', array(
	'class' => 'margin-bottom'
));
```

####Errors and values
These functions are what makes Gentleform nice to use. Instead of having exposed ifs and echos for values and errors, we use the following functions to make our code pretty.

#####addErrors($errors = array())
This function adds errors to the form. These errors are added on to the attrbutes of inputs or textareas as a ```data-error``` attribute. This is how errors are shown on Blogcase. The array passed in uses the field name as the key, and the error text as the value.

```PHP
$form->addErrors(array(
	'user_bio' => 'Max length of 255 characters for a users biography',
	'first_name' => 'This cannot be blank'
));
```

These errors are then automatically added when the input is echo'd.

#####addValues($values = array())
Just like errors, you pass in an array of values for the fields. The form name as the key, and the value as the...value. These will then be added to inputs as values, or textareas as the child text.

```PHP
$form->addValues(array(
	'user_bio' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit officiis nostrum quasi eius nam rem provident? Magnam odit laborum aliquam nulla modi quia doloremque minus dolores! Debitis, temporibus iure quos.',
	'first_name' => ''
));
```

#####clearErrors() & clearValues()
You can clear the values or errors stored manually. These functions are called when you end a form.

```PHP
$form->clearErrors();
$form->clearValues();
```

##Helping
Feel free to help out and submit pull requests! Also feel free to give feedback and tweet me on your wanting to ask questions.

[@andrewhathaway](http://twitter.com/andrewhathaway)
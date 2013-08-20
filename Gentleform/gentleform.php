<?php

/**
 * Gentleform
 * Forms like a gentleman in PHP.
 *
 * @author Andrew Hathaway <andrew@andrewhathaway.net>
 */

class GentleForm {

	/**
	 * Errors for fields
	 */
	private $inputErrors = array();

	/**
	 * Values for fields
	 */
	private $inputValues = array();

	/**
	 * Automatically create labels for inputs
	 */
	public $autoLabel = true;

	/**
	 * The start of the form creation
	 * @param  string $url    The URL for the form to submit to
	 * @param  string $method The forms method attribute
	 * @param  array  $params The form param
	 * @return string         HTML string
	 */
	public function create($url, $method = 'post', $params = array()) {
		$string = '<form';

		$extras = array(
			'action' => $url,
			'method' => $method
		);

		$string .= $this->prepareFields($extras, $params) . '>';

		return $string;
	}

	/**
	 * The end of a form
	 * @param  string $text   Button text
	 * @param  array  $params Array of options
	 * @return string         The form end
	 */
	public function end($text = 'Submit', $params = array()) {
		$string = '';

		if($text) {
			$string .= $this->submit($text, $params);
		}

		$string .= '</form>';

		$this->clearErrors();
		$this->clearValues();

		return $string;
	}

	/**
	 * Create a submit button
	 * @param  string $text   The button text
	 * @param  array  $params Parameteres for the input
	 * @return string         HTML submit button
	 */
	public function submit($text = 'Submit', $params = array()) {
		$string = '<input';

		$attributes = $this->prepareFields(array(
			'type' => 'submit',
			'value' => $text
		), $params);

		$string .= $attributes . '>';

		return $string;
	}

	/**
	 * Create an input
	 * @param  string $name   Input name
	 * @param  string $type   Input type
	 * @param  array  $params Input parameters
	 * @return string         Rendered input HTML
	 */
	public function input($name, $type = 'text', $params = array()) {
		$label = '';

		if($this->autoLabel) {
			$label = $this->prepareLabel($name, $params);
		}

		$string = $label . '<input';

		$extras = array(
			'type' => $type,
			'name' => $name
		);

		$extras = array_merge($extras, $this->prepareExtras($name));
		$attributes = $this->prepareFields($extras, $params);

		$string .= $attributes . '>';

		return $string;
	}

	/**
	 * Create a textarea
	 * @param  string $name   The name of the field
	 * @param  array  $params Parameters for the field
	 * @return string         HTML textarea
	 */
	public function textarea($name, $params = array()) {
		$label = '';

		if($this->autoLabel) {
			$label = $this->prepareLabel($name, $params);
		}

		$string = $label . '<textarea';

		$extras = array(
			'name' => $name
		);

		if(isset($this->inputErrors[$name])) {
			$extras['data-error'] = $this->inputErrors[$name];
		}

		$attributes = $this->prepareFields($extras, $params);

		$string .= $attributes . '>';

		if(isset($this->inputValues[$name])) {
			$string .= $this->inputValues[$name];
		}

		$string .= '</textarea>';

		return $string;
	}

	/**
	 * Creates a HTML label
	 * @param  string $text  The label text
	 * @param  array $param  Parameters for the label
	 * @return string        HTML label
	 */
	public function label($text, $params = array()) {
		$string = '<label';

		$string .= $this->toAttrString($params) . '>' . $text . '</label>';
		return $string;
	}

	/**
	 * Prepares a label for an input
	 * @param  string $label_text String text for the label
	 * @param  array  $params     Label parameters
	 * @return [type]             The HTML label
	 */
	public function prepareLabel($label_text, &$params = array()) {
		$label = '';

		if(!isset($params['label'])) {
			$label_text = $this->humanize($label_text);
			$label = $this->label($label_text);
		} else {
			if(!$params['label']) {
				unset($params['label']);
				return $label;
			}

			if(!is_array($params['label'])) {
				$label_text = $this->humanize($params['label']);
				$label = $this->label($label_text);
			} else {
				$label_text = $this->humanize($params['label']['text']);

				unset($params['label']['text']);
				$label = $this->label($label_text, $params['label']);
			}
		}

		unset($params['label']);
		return $label;
	}

	/**
	 * Add errors to form inputs
	 * @param array $erorrs Array of errors - field => message
	 */
	public function addErrors($errors = array()) {
		$this->inputErrors = array_merge($this->inputErrors, $errors);
	}

	/**
	 * Add values to form inputs
	 * @param array $values Array of values - field => value
	 */
	public function addValues($values = array()) {
		$this->inputValues = array_merge($this->inputValues, $values);
	}

	/**
	 * Remove a certain error, or groups
	 * @param  string/array $name The name of the field to remove
	 */
	public function removeError($name) {
		if(!is_array($name)) {
			unset($this->inputErrors[$name]);
		} else {
			foreach($name as $key) {
				unset($this->inputErrors[$name]);
			}
		}
	}

	/**
	 * Remove a certain value, or a group
	 * @param  string/array $name The name of the field to remove
	 */
	public function removeValue($name) {
		if(!is_array($name)) {
			unset($this->inputValues[$name]);
		} else {
			foreach($name as $key) {
				unset($this->inputValues[$name]);
			}
		}
	}

	/**
	 * Clears the errors array
	 */
	public function clearErrors() {
		$this->inputErrors = array();
	}

	/**
	 * Clears the values array
	 */
	public function clearValues() {
		$this->inputValues = array();
	}

	/**
	 * Merge an array and create the attribute string
	 * @param  arrray $array_one First array to merge
	 * @param  array $array_two  Second array to merge
	 * @return string            Attribute string
	 */
	private function prepareFields($array_one, $array_two) {
		$array = array_merge($array_one, $array_two);
		return $this->toAttrString($array);
	}

	/**
	 * Prepares values and errors for fields
	 * @param  string $name The name of the field
	 * @return array        The array of extras
	 */
	private function prepareExtras($name) {
		$extras = array();

		if(isset($this->inputValues[$name])) {
			$extras['value'] = $this->inputValues[$name];
		}

		if(isset($this->inputErrors[$name])) {
			$extras['data-error'] = $this->inputErrors[$name];
		}

		return $extras;
	}

	/**
	 * Convert an array to attribute string
	 * @param  array $attributes  Array of attributes
	 * @return string             String of attributes
	 */
	private function toAttrString($attributes) {
		$string = '';

		foreach($attributes as $attribute => $value) {
			$string .= ' ' . $attribute . '="' . $value . '"';
		}

		return $string;
	}

	/**
	 * Humanize a string
	 * http://www.westhost.com/contest/php/function/string-utils/82
	 * @param  string $str Un-human string
	 * @return String      Human string
	 */
	private function humanize($string) {
		$result = strtolower(trim($string));
		$result = ucwords(preg_replace('/[_]+/', ' ', $result));

		return $result;
    }

}
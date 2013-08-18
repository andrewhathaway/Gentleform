<?php

class GentleForm {

	/**
	 * Errors for fields
	 */
	private $input_errors = array();

	/**
	 * Values for fields
	 */
	private $input_values = array();

	/**
	 * Automatically create labels for inputs
	 */
	public $auto_label = true;

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

		$string .= $this->prepare_fields($extras, $params) . '>' . PHP_EOL;

		return $string;
	}

	/**
	 * The end of a form
	 * @param  string $text   Button text
	 * @param  array  $params Array of options
	 * @return string         The form end
	 */
	public function end($text = null, $params = array()) {
		$string = '';

		if(!is_null($text)) {
			$attributes = $this->prepare_fields(array(
				'type' => 'submit',
				'value' => $text
			), $params);

			$string .= '<input' . $attributes . '>' . PHP_EOL;
		}

		$string .= '</form>';

		$this->clearErrors();
		$this->clearValues();

		return $string;
	}

	/**
	 * [input description]
	 * @param  string $name   Input name
	 * @param  string $type   Input type
	 * @param  array  $params Input parameters
	 * @return string         Rendered input HTML
	 */
	public function input($name, $type = 'text', $params = array()) {
		$label = '';

		if($this->auto_label) {
			$label = $this->prepare_label($name, $params);
		}

		$string = $label . '<input';

		$extras = array(
			'type' => $type,
			'name' => $name
		);

		$extras = array_merge($extras, $this->prepare_extras($name));
		$attributes = $this->prepare_fields($extras, $params);

		$string .= $attributes . '>' . PHP_EOL;

		return $string;
	}

	public function textarea($name, $params = array()) {
		$string = '<textarea';

		$extras = array(
			'name' => $name
		);

		if(isset($this->input_errors[$name])) {
			$extras['data-error'] = $this->input_errors[$name];
		}

		$attributes = $this->prepare_fields($extras, $params);

		$string .= $attributes . '>';

		if(isset($this->input_values[$name])) {
			$string .= $this->input_values[$name];
		}

		$string .= '</textarea>' . PHP_EOL;

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

		$string .= $this->to_attr_string($params) . '>' . $text . '</label>' . PHP_EOL;
		return $string;
	}

	public function prepare_label($label_text, &$params = array()) {
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
		$this->input_errors = array_merge($this->input_errors, $errors);
	}

	/**
	 * Add values to form inputs
	 * @param array $values Array of values - field => value
	 */
	public function addValues($values = array()) {
		$this->input_values = array_merge($this->input_values, $values);
	}

	/**
	 * Clears the errors array
	 */
	public function clearErrors() {
		$this->input_errors = array();
	}

	/**
	 * Clears the values array
	 */
	public function clearValues() {
		$this->input_values = array();
	}

	/**
	 * Merge an array and create the attribute string
	 * @param  arrray $array_one First array to merge
	 * @param  array $array_two  Second array to merge
	 * @return string            Attribute string
	 */
	private function prepare_fields($array_one, $array_two) {
		$array = array_merge($array_one, $array_two);
		return $this->to_attr_string($array);
	}

	/**
	 * Prepares values and errors for fields
	 * @param  string $name The name of the field
	 * @return array        The array of extras
	 */
	private function prepare_extras($name) {
		$extras = array();

		if(isset($this->input_values[$name])) {
			$extras['value'] = $this->input_values[$name];
		}

		if(isset($this->input_errors[$name])) {
			$extras['data-error'] = $this->input_errors[$name];
		}

		return $extras;
	}

	/**
	 * Convert an array to attribute string
	 * @param  array $attributes  Array of attributes
	 * @return string             String of attributes
	 */
	private function to_attr_string($attributes) {
		$string = '';

		foreach($attributes as $attribute => $value) {
			$string .= ' ' . $attribute . '="' . $value . '"';
		}

		return $string;
	}

	/**
	 * Humanize a string
	 * - http://www.westhost.com/contest/php/function/string-utils/82
	 * @param  string $str Un-human string
	 * @return String      Human string
	 */
	private function humanize($string) {
		$result = strtolower(trim($string));
		$result = ucwords(preg_replace('/[_]+/', ' ', $result));

		return $result;
    }

}
<?php

class FormMaster {

	/**
	 * Errors for fields
	 */
	private $input_errors = array();

	/**
	 * Values for fields
	 */
	private $input_values = array();

	/**
	 * The start of the form creation
	 * @param  string $url    The URL for the form to submit to
	 * @param  string $method The forms method attribute
	 * @param  array  $params The form param
	 * @return string         HTML string
	 */
	public function create($url, $method = 'get', $params = array()) {
		$string = '<form action="' . $url . '" method="' . $method . '"' . $this->to_attr_string($params) . '>' . PHP_EOL;

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
		$string = '<input';

		$attributes = $this->prepare_fields(array(
			'type' => $type,
			'name' => $name
		), $params);

		$string .= $attributes . '>' . PHP_EOL;

		return $string;
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
	 * Merge an array and create the attribute string
	 * @param  arrray $array_one First array to merge
	 * @param  array $array_two  Second array to merge
	 * @return string            Attribute string
	 */
	public function prepare_fields($array_one, $array_two) {
		$array = array_merge($array_one, $array_two);
		return $this->to_attr_string($array);
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

}
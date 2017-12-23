<?php

namespace Website;
use \Website\Model\User;

class Model
{

	private $data = [];

	function __set($name, $values){
		$this->data[$name] = $values;
	}

	function __get($name){
		return $this->data[$name];
	}

	public function setData($data = array())
	{
		foreach ($data as $key => $value) {
			$this->$key = $value;
		}
	}

	public function getData()
	{
		return $this->data;
	}


}

?>
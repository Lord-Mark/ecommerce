<?php
namespace Website;

use Rain\Tpl;

class Page
{
	private $tpl;
	private $options = [];
	private $defaults = [
		"data" => []
	];

	function __construct($opts = array(), $tpl_dir = "views/")
	{
		$this->options = array_merge($this->defaults, $opts);

		$config = array(
			"tpl_dir" 	=> $_SERVER["DOCUMENT_ROOT"] . "/" . $tpl_dir,
			"cache_dir" => $_SERVER["DOCUMENT_ROOT"] . "/views-cache/",
			"debug" 	=> false
		);

		$this->tpl = new Tpl;
		
		Tpl::configure($config);

		$this->setData($this->options["data"]);

		$this->tpl->draw("master/header");
	}

	private function setData($data = array())
	{
		foreach ($data as $key => $value) {
			$this->tpl->assign($key, $value);
		}
	}

	public function setTpl( $name, $data = array(), $returnHTML = false )
	{
		$this->setData($data);

		return $this->tpl->draw($name, $returnHTML);
	}

	function __destruct()
	{
		$this->tpl->draw("master/footer");
	}
}

?>
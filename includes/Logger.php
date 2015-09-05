<?php

class Logger {

	public $file;
	public $enabled;

	/**
	 * @param bool|true $enabled
	 * @param string $file
	 */
	public function __construct($enabled = true, $file = 'log.txt') {
		$this->file = $file;
		$this->enabled = $enabled;
	}

	/**
	 * @param $data
	 * @param $requestData
	 * @return mixed
	 */
	public function log($data, $requestData) {
		if($this->enabled)
			@file_put_contents('log.txt', date('l jS \of F Y h:i:s A').' - '.$data.PHP_EOL.$requestData.PHP_EOL.'---'.PHP_EOL, FILE_APPEND | LOCK_EX);

		return $data;
	}

}
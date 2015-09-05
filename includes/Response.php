<?php

class Response {

	public $encrypt;

	/**
	 * @param bool|false $encrypt
	 */
	public function __construct($encrypt = false) {
		$this->encrypt = $encrypt;
	}

	/**
	 * Return encrypted response
	 * @param boolean $response 
	 * @return mixed
	 */
	public function response($response) {

        /* Encrypt the result */
		if ($this->encrypt) {
            $result = base64_encode($response);
            echo $result;
        }

        echo $response;
	}

}
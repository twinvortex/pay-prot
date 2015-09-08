<?php

class Response
{

    public $isEncrypted;
    private $encryptionKey;

    /**
     * @param bool|false $isEncrypted
     * @param $encryptionKey
     */
    public function __construct($isEncrypted = false, $encryptionKey)
    {
        $this->isEncrypted = $isEncrypted;
        $this->setEncriptionKey($encryptionKey);
    }

    public function setEncriptionKey($encryptionKey)
    {
        $this->encryptionKey = $encryptionKey;
    }

    public function getEncryptionKey()
    {
        return $this->encryptionKey;
    }

    /**
     * @param $response
     */
    public function response($response)
    {

        /* Encrypt the result */
        if ($this->isEncrypted) {
            $result = $this->encrypt($response);
            echo $result;
        }

        echo $response;
    }

    public function encrypt($string)
    {
        $key = $this->getEncryptionKey();
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }

        return base64_encode($result);

    }

    public function decrypt($string)
    {
        $key = $this->getEncryptionKey();
        $result = '';
        $string = base64_decode($string);

        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
        }

        return $result;
    }

}
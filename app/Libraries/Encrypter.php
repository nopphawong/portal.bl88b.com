<?php

namespace App\Libraries;

use Config\Encryption;
use Config\Services;

class Encrypter
{
    private $config;
    private $encrypter;
    public function __construct()
    {
        $this->config = new Encryption();
        $this->config->key = $_ENV["app.appKey"];
        $this->encrypter = Services::encrypter($this->config);
    }
    public function array_to_plaintext($data = array())
    {
        return implode(DIRECTORY_SEPARATOR, $data);
    }
    public function plaintext_to_array($plaintext)
    {
        return explode(DIRECTORY_SEPARATOR, $plaintext);
    }

    public function data_to_plaintext($data = array())
    {
        return json_encode($data);
    }
    public function plaintext_to_data($plaintext)
    {
        return json_decode($plaintext);
    }

    public function encode($plaintext)
    {
        return bin2hex($this->encrypter->encrypt($plaintext));
    }
    public function decode($encoded)
    {
        return $this->encrypter->decrypt(hex2bin($encoded));
    }
}

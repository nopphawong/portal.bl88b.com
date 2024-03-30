<?php

namespace App\Controllers\serv;

use App\Controllers\RestController;
use App\Libraries\Portal;

class Auth extends RestController {
    public function unauthen() {
        return $this->sendData(null, "Please Login !", false);
    }
    public function deny() {
        return $this->sendData(null, "Access deny !", false);
    }
    public function login() {
        $body = $this->getPost();
        $portal = new Portal();
        $login = $portal->login($body);
        if (!$login->status) return $this->sendData(null, $login->message, false);
        return $this->sendData($login->data);
    }
    public function register() {
        $body = $this->getPost();

        return $this->sendData($body, "Welcome !", false);
    }
}

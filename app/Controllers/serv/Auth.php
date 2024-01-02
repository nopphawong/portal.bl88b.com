<?php

namespace App\Controllers\serv;

use App\Libraries\Portal;
use App\Models\AgentModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function unauthen()
    {
        return $this->sendData(null, "Please Login !", false);
    }
    public function deny()
    {
        return $this->sendData(null, "Access deny !", false);
    }
    public function login()
    {
        $body = $this->getPost();
        $portal = new Portal();
        $login = $portal->login($body);
        if (!$login->status) return $this->sendData(null, $login->message, false);
        return $this->sendData(["url" => $login->data->url]);
    }
    public function register()
    {
        $body = $this->getPost();

        return $this->sendData($body, "Welcome !", false);
    }
}

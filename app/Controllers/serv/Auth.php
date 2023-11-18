<?php

namespace App\Controllers\serv;

use App\Libraries\Portal;
use App\Models\AgentModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function unauthen()
    {
        return $this->response(null, "Please Login !", false);
    }
    public function deny()
    {
        return $this->response(null, "Access deny !", false);
    }
    public function login()
    {
        $body = $this->getPost();
        $portal = new Portal();
        $login = $portal->login($body);
        if (!$login->status) return $this->response(null, $login->message, false);
        return $this->response(["url" => $login->data->url]);
    }
    public function register()
    {
        $body = $this->getPost();

        return $this->response($body, "Welcome !", false);
    }
}

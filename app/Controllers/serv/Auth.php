<?php

namespace App\Controllers\serv;

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
        $userModel = new UserModel();
        $user = $userModel->where("username", $body->username)->first();
        if (empty($user)) return $this->response(null, "Username not found !", false);
        if ($user->password != $body->password) return $this->response(null, "Password not match !", false);
        if (!$user->status) return $this->response(null, "Username inactived !", false);

        $agentModel = new AgentModel();
        $agent = $agentModel->where("key", $user->agent)->first();
        if (empty($agent)) return $this->response(null, "Agent not found !", false);
        if (!$agent->status) return $this->response(null, "Agent inactived !", false);
        $this->set_session($user, $agent);
        return $this->response(["url" => site_url("agent/info")], "Welcome !");
    }
    protected function set_session($user, $agent)
    {
        $data = [
            "logged_in" => true,
            "username" => $user->username,
            "role" => $user->role,
            "agent" => (object) [
                "code" => $agent->code,
                "key" => $agent->key,
                "secret" => $agent->secret,
            ],
        ];
        session()->set($data);
    }

    public function register()
    {
        $body = $this->getPost();

        return $this->response($body, "Welcome !", false);
    }
}

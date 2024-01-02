<?php

namespace App\Controllers\api;

use App\Libraries\Encrypter;
use App\Models\AgentModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        $body = $this->getPost();

        $userModel = new UserModel();
        $user = $userModel->where("username", $body->username)->first();
        if (empty($user)) return $this->sendData(null, "Username not found !", false);
        if ($user->password != $body->password) return $this->sendData(null, "Password not match !", false);
        if (!$user->status) return $this->sendData(null, "Username inactived !", false);

        if (is_master($user->role)) return $this->return_sendData($user);

        $agentModel = new AgentModel();
        $agent = $agentModel->where("code", $user->agent)->first();
        if (empty($agent)) return $this->sendData(null, "Agent not found !", false);
        if (!$agent->status) return $this->sendData(null, "Agent inactived !", false);

        return $this->return_sendData($user, $agent);
    }

    protected function return_sendData($user, $agent = null)
    {
        $session_data = [
            "logged_in" => true,
            "username" => $user->username,
            "role" => $user->role,
        ];
        if ($agent) {
            $agent = (object) $agent;
            $session_data["agent"] = (object) array(
                "code" => $agent->code,
                "key" => $agent->key,
                "secret" => $agent->secret,
                "name" => $agent->name,
            );
        }

        $ect = new Encrypter();
        $plaintext = $ect->data_to_plaintext($session_data);
        $encoded = $ect->encode($plaintext);
        return $this->sendData(["url" => site_url("detect/{$encoded}")], $encoded);
    }
}

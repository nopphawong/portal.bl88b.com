<?php

namespace App\Controllers\api;

use App\Controllers\RestController;
use App\Models\AgentModel;
use App\Models\UserModel;

class User extends RestController {
    public function list() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $userModel = new UserModel();
        if ($body->role) $userModel->where("role", $body->role);
        $banners = $userModel->where("agent", $body->agent)->findAll();

        return $this->sendData($banners);
    }

    public function add() {
        $body = $this->getPost();
        if (!$this->validate_username($body->username)) return $this->sendData(null, "Invalide username !", false);
        if (!$this->validate_password($body->password)) return $this->sendData(null, "Invalide password !", false);

        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $userModel = new UserModel();
        $user = $userModel->where("username", $body->username)->first();
        if ($user) return $this->sendData(null, "Duplicate username !", false);

        $body->add_date = date('Y-m-d H:i:s');
        $id = $userModel->insert($body);
        $user = $userModel->find($id);
        return $this->sendData($user);
    }

    public function info() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $userModel = new UserModel();
        $user = $userModel->find($body->id);
        if (!$user) return $this->sendData(null, "User not found !", false);

        return $this->sendData($user);
    }

    public function info_update() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        unset($body->username);

        $userModel = new UserModel();
        $body->edit_date = date('Y-m-d H:i:s');
        $userModel->save($body);
        $user = $userModel->find($body->id);
        return $this->sendData($user);
    }

    public function status_inactive() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $userModel = new UserModel();
        $user = $userModel->find($body->id);
        if (!$user) return $this->sendData(null, "User not found !", false);
        $user->status = 0;
        $user->edit_date = date('Y-m-d H:i:s');
        $userModel->save($user);
        return $this->sendData($user);
    }

    public function status_active() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $userModel = new UserModel();
        $user = $userModel->find($body->id);
        if (!$user) return $this->sendData(null, "User not found !", false);
        $user->status = 1;
        $user->edit_date = date('Y-m-d H:i:s');
        $userModel->save($user);
        return $this->sendData($user);
    }

    public function record_delete() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $userModel = new UserModel();
        $user = $userModel->find($body->id);
        if (!$user) return $this->sendData(null, "User not found !", false);
        $userModel->delete($user->id);
        return $this->sendData($user);
    }
}

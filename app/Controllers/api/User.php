<?php

namespace App\Controllers\api;

use App\Models\AgentModel;
use App\Models\UserModel;

class User extends BaseController
{
    public function list()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $userModel = new UserModel();
        if ($body->role) $userModel->where("role", $body->role);
        $banners = $userModel->where("agent", $body->agent)->findAll();

        return $this->response($banners);
    }

    public function add()
    {
        $body = $this->getPost();
        if (!$this->validate_username($body->username)) return $this->response(null, "Invalide username !", false);
        if (!$this->validate_password($body->password)) return $this->response(null, "Invalide password !", false);

        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $userModel = new UserModel();
        $user = $userModel->where("username", $body->username)->first();
        if ($user) return $this->response(null, "Duplicate username !", false);

        $body->add_date = date('Y-m-d H:i:s');
        $id = $userModel->insert($body);
        $banner = $userModel->find($id);
        return $this->response($banner);
    }

    public function info()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $userModel = new UserModel();
        $banner = $userModel->find($body->id);

        return $this->response($banner);
    }

    public function info_update()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        unset($body->username);

        $userModel = new UserModel();
        $body->edit_date = date('Y-m-d H:i:s');
        $userModel->save($body);
        $banner = $userModel->find($body->id);
        return $this->response($banner);
    }

    public function status_inactive()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $userModel = new UserModel();
        $banner = $userModel->find($body->id);
        $banner->status = 0;
        $banner->edit_date = date('Y-m-d H:i:s');
        $userModel->save($banner);
        return $this->response($banner);
    }

    public function status_active()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->response(null, "Invalide agent !", false);

        $userModel = new UserModel();
        $banner = $userModel->find($body->id);
        $banner->status = 1;
        $banner->edit_date = date('Y-m-d H:i:s');
        $userModel->save($banner);
        return $this->response($banner);
    }
}

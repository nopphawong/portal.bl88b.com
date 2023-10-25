<?php

namespace App\Controllers\api;

use App\Models\AgentModel;

class Agent extends BaseController
{
    public function info()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->agent) return $this->response(null, "Invalide agent !", false);

        return $this->response($agent);
    }

    public function info_update()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->response(null, "Invalide agent !", false);
        if ($agent->key != $body->agent) return $this->response(null, "Invalide agent !", false);

        $body->id = $agent->id;
        $body->edit_date = date("Y-m-d H:i:s");
        $agentModel->save($body);
        $agent = $agentModel->find($agent->id);
        return $this->response($agent, "Update successful !");
    }

    public function add()
    {
        $body = $this->getPost();
        if (empty($body->code) || empty($body->key) || empty($body->secret))  return $this->response(null, "Agent code, key or secret is empty !", false);

        $agentModel = new AgentModel();
        $agent = $agentModel->orWhere("code", $body->code)->orWhere("key", $body->key)->orWhere("secret", $body->secret)->first();
        if ($agent) return $this->response(null, "Agent code, key or secret is duplicate !", false);
        $body->add_date = date("Y-m-d H:i:s");
        $id = $agentModel->insert($body);
        $agent = $agentModel->find($id);
        return $this->response($agent, "Add successful !");
    }
}

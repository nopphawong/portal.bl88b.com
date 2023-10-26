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

        unset($body->key, $body->secret, $body->code);
        $body->id = $agent->id;
        $body->edit_date = date("Y-m-d H:i:s");
        $agentModel->save($body);
        $agent = $agentModel->find($agent->id);
        return $this->response($agent, "Update successful !");
    }

    public function add()
    {
        $body = $this->getPost();
        if (empty($body->key) || empty($body->secret))  return $this->response(null, "Agent key or secret is empty !", false);

        $agentModel = new AgentModel();
        $agent = $agentModel->orWhere("key", $body->key)->orWhere("secret", $body->secret)->first();
        if ($agent) return $this->response(null, "Agent key or secret is duplicate !", false);

        $running = 0;
        $prefix = "ag";
        $agent = $agentModel->where("code like '{$prefix}%'")->orderBy("code desc")->first();
        if ($agent) {
            $running = str_replace($prefix, "", $agent->code);
        }
        $running += 1;
        $body->code = "{$prefix}{$running}";
        $body->add_date = date("Y-m-d H:i:s");
        $id = $agentModel->insert($body);
        $agent = $agentModel->find($id);
        return $this->response($agent, "Add successful !");
    }
}

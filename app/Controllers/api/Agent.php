<?php

namespace App\Controllers\api;

use App\Controllers\RestController;
use App\Models\AgentModel;

class Agent extends RestController {
    public function list() {
        // $body = $this->getPost();
        $agentModel = new AgentModel();
        $agents = $agentModel->findAll();

        return $this->sendData($agents);
    }

    public function info() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        return $this->sendData($agent);
    }

    public function info_update() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        unset($body->key, $body->secret, $body->code);
        $body->id = $agent->id;
        $body->edit_date = date("Y-m-d H:i:s");
        $agentModel->save($body);
        $agent = $agentModel->find($agent->id);
        return $this->sendData($agent, "Update successful !");
    }

    public function add() {
        $body = $this->getPost();
        if (empty($body->key) || empty($body->secret))  return $this->sendData(null, "Agent key or secret is empty !", false);

        $agentModel = new AgentModel();
        $agent = $agentModel->orWhere("key", $body->key)->orWhere("secret", $body->secret)->first();
        if ($agent) return $this->sendData(null, "Agent key or secret is duplicate !", false);

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
        return $this->sendData($agent, "Add successful !");
    }

    public function config() {
        $body = $this->getPost();
        if (empty($body->key) || empty($body->secret))  return $this->sendData(null, "Agent key or secret is empty !", false);

        $agentModel = new AgentModel();
        // $agent = $agentModel->where("(")->orWhere("key", $body->key)->orWhere("secret", $body->secret)->where(")")->where("id !=", $body->id)->first();
        $agent = $agentModel->where("(key = '{$body->key}' or secret = '{$body->secret}')")->where("id !=", $body->id)->first();
        // $subquery = $agentModel->orWhere("key", $body->key)->orWhere("secret", $body->secret)->getCompiledSelect();
        // $agent = $agentModel->whereIn("id", $subquery)->where("id !=", $body->id)->first();
        if ($agent) return $this->sendData(null, "Agent key or secret is duplicate !", false);

        $body->edit_date = date("Y-m-d H:i:s");
        $agentModel->save($body);
        $agent = $agentModel->find($body->id);
        return $this->sendData($agent, "Config successful !");
    }

    public function status_inactive() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $agent = $agentModel->find($body->id);
        $agent->status = 0;
        $agent->edit_date = date('Y-m-d H:i:s');
        $agentModel->save($agent);
        return $this->sendData($agent);
    }

    public function status_active() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $agent = $agentModel->find($body->id);
        $agent->status = 1;
        $agent->edit_date = date('Y-m-d H:i:s');
        $agentModel->save($agent);
        return $this->sendData($agent);
    }
}

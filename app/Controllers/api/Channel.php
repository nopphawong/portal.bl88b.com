<?php

namespace App\Controllers\api;

use App\Controllers\RestController;
use App\Models\AgentModel;
use App\Models\ChannelModel;

class Channel extends RestController {
    public function list() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $ChannelModel = new ChannelModel();
        $channels = $ChannelModel->select("ref, name, description, concat('{$agent->url}register?ref=', ref) as link")
            ->where("status", 1)->where("agent", $agent->code)->findAll();
        return $this->sendData($channels);
    }
}

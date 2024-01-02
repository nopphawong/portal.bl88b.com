<?php

namespace App\Controllers\api;

use App\Models\AgentModel;
use App\Models\ProgressModel;

class Progress extends BaseController
{
    public function list()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $progressModel = new ProgressModel();
        $progresses = $progressModel->where("checkin", $body->checkin)->where("agent", $agent->code)->orderBy("index")->findAll();

        return $this->sendData($progresses);
    }
    public function add()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $progressModel = new ProgressModel();
        $body->add_date = date('Y-m-d H:i:s');
        $id = $progressModel->insert($body);
        $progress = $progressModel->find($id);
        return $this->sendData($progress);
    }
    public function info()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $progressModel = new ProgressModel();
        $progress = $progressModel->where("id", $body->id)->where("agent", $agent->code)->first();
        if (!$progress) return $this->sendData(null, "Progress not found !", false);

        return $this->sendData($progress);
    }
    public function info_update()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $progressModel = new ProgressModel();
        $body->edit_date = date('Y-m-d H:i:s');
        $progressModel->save($body);
        $progress = $progressModel->find($body->id);
        return $this->sendData($progress);
    }
}

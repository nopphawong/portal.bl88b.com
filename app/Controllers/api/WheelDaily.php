<?php

namespace App\Controllers\api;

use App\Models\AgentModel;
use App\Models\WheelDailyModel;

class WheelDaily extends BaseController
{
    protected $types = array(
        "USABLE" => "usable",
        "CLAIMABLE" => "claimable",
    );
    public function list($type = null)
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $wheelDailyModel = new WheelDailyModel();
        if ($body->user) $wheelDailyModel->where("user", $body->user);
        if ($body->wheel) $wheelDailyModel->where("wheel", $body->wheel);
        if ($type == $this->types["USABLE"]) $wheelDailyModel->where("status", 1)->where("ifnull(date_use,'') = ''");
        if ($type == $this->types["CLAIMABLE"]) $wheelDailyModel->where("status", 1)->where("ifnull(date_use,'') != ''")->where("ifnull(date_claim,'') = ''");
        $wheelDailies = $wheelDailyModel->where("agent", $agent->code)->findAll();

        return $this->sendData($wheelDailies);
    }
    public function add()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $wheelDailyModel = new WheelDailyModel();
        $wheelDaily = $wheelDailyModel
            ->where("agent", $agent->code)
            ->where("user", $body->user)
            ->where("date", $body->date)
            ->where("status", 1);
        $wheelDaily = $wheelDailyModel->first();
        if ($wheelDaily) return $this->sendData(null, "Can't add same date !", false);

        $body->agent = $agent->code;
        $body->add_date = date('Y-m-d H:i:s');
        $id = $wheelDailyModel->insert($body);
        $wheelDaily = $wheelDailyModel->find($id);
        return $this->sendData($wheelDaily);
    }
    public function info()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $wheelDailyModel = new WheelDailyModel();
        $wheelDailyModel->where("id", $body->id);
        $wheelDailyModel->where("user", $body->user);
        $wheelDailyModel->where("wheel", $body->wheel);
        $wheelDaily = $wheelDailyModel->where("agent", $agent->code)->first();

        return $this->sendData($wheelDaily);
    }
    public function roll()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $wheelDailyModel = new WheelDailyModel();
        $wheelDailyModel
            ->where("agent", $agent->code)
            ->where("user", $body->user)
            ->where("wheel", $body->wheel)
            ->where("status", 1)
            ->where("ifnull(date_use,'') = ''");
        $wheelDaily = $wheelDailyModel->first();
        if (!$wheelDaily) return $this->sendData(null, "Can't roll !", false);

        $body->id = $wheelDaily->id;
        $body->date_use = date('Y-m-d H:i:s');
        $body->edit_date = date('Y-m-d H:i:s');
        $wheelDailyModel->update($body->id, $body);
        $wheelDaily = $wheelDailyModel->find($body->id);
        return $this->sendData($wheelDaily);
    }
    public function claim()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $wheelDailyModel = new WheelDailyModel();
        $wheelDailyModel
            ->where("id", $body->id)
            ->where("agent", $agent->code)
            ->where("user", $body->user)
            ->where("wheel", $body->wheel)
            ->where("status", 1)
            ->where("ifnull(date_use,'') != ''")
            ->where("ifnull(date_claim,'') = ''");
        $wheelDaily = $wheelDailyModel->first();
        if (!$wheelDaily) return $this->sendData(null, "Can't claim !", false);

        $body->date_claim = date('Y-m-d H:i:s');
        $body->edit_date = date('Y-m-d H:i:s');
        $wheelDailyModel->update($body->id, $body);
        $wheelDaily = $wheelDailyModel->find($body->id);
        return $this->sendData($wheelDaily);
    }
}

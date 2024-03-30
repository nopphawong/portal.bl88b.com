<?php

namespace App\Controllers\api;

use App\Controllers\RestController;
use App\Models\AgentModel;
use App\Models\CheckinModel;

class Checkin extends RestController {
    public function list() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $checkinModel = new CheckinModel();
        $checkins = $checkinModel->where("agent", $agent->code)->findAll();

        return $this->sendData($checkins);
    }
    public function add() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $checkinModel = new CheckinModel();
        $body->add_date = date('Y-m-d H:i:s');
        $id = $checkinModel->insert($body);
        $checkin = $checkinModel->find($id);
        return $this->sendData($checkin);
    }
    public function info() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $checkinModel = new CheckinModel();
        $checkin = $checkinModel->where("id", $body->id)->where("agent", $agent->code)->findAll();
        if (!$checkin) return $this->sendData(null, "Checkin not found !", false);

        return $this->sendData($checkin);
    }
    public function info_update() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);
        if (!$this->is_number($body->deposit_rule)) return $this->sendData(null, "Invalide Deposit rules !", false);

        $checkinModel = new CheckinModel();
        $body->edit_date = date('Y-m-d H:i:s');
        $checkinModel->save($body);
        $checkin = $checkinModel->find($body->id);
        return $this->sendData($checkin);
    }
    public function first() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $checkinModel = new CheckinModel();
        $checkin = $checkinModel->where("agent", $agent->code)->where("status", 1)->first();
        if (!$checkin) return $this->sendData(null, "Checkin not found !", false);

        return $this->sendData($checkin);
    }
}

<?php

namespace App\Controllers\api;

use App\Models\AgentModel;
use App\Models\CheckinDailyModel;
use App\Models\ProgressModel;

class CheckinDaily extends BaseController
{
    protected $types = array(
        "USABLE" => "usable",
        "CLAIMABLE" => "claimable",
        "HISTORY" => "history",
    );
    public function list($type = null)
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        // return $this->sendData($body);
        $checkinDailyModel = new CheckinDailyModel();
        if (isset($body->user) && $body->user) $checkinDailyModel->where("user", $body->user);
        if (isset($body->checkin) && $body->checkin) $checkinDailyModel->where("checkin", $body->checkin);
        if (isset($body->date) && $body->date) $checkinDailyModel->where("date_format(date,'%Y%m')", date_format(date_create($body->date), "Ym"));
        if ($type == $this->types["HISTORY"]) $checkinDailyModel->where("status", 1)->where("ifnull(date_use,'') != ''")->where("ifnull(value,'') != ''");
        if ($type == $this->types["USABLE"]) $checkinDailyModel->where("status", 1)->where("ifnull(date_use,'') = ''");
        if ($type == $this->types["CLAIMABLE"]) $checkinDailyModel->where("status", 1)->where("ifnull(date_use,'') != ''")->where("ifnull(date_claim,'') = ''");
        $checkinDailies = $checkinDailyModel->where("agent", $agent->code)->findAll();

        return $this->sendData($checkinDailies);
    }
    /* public function add() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $checkinDailyModel = new CheckinDailyModel();
        $checkinDaily = $checkinDailyModel
            ->where("agent", $agent->code)
            ->where("user", $body->user)
            ->where("date", $body->date)
            ->where("status", 1);
        $checkinDaily = $checkinDailyModel->first();
        if ($checkinDaily) return $this->sendData(null, "Can't add same date !", false);

        $body->agent = $agent->code;
        $body->add_date = date('Y-m-d H:i:s');
        $id = $checkinDailyModel->insert($body);
        $checkinDaily = $checkinDailyModel->find($id);
        return $this->sendData($checkinDaily);
    } */
    public function add()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $checkinDailyModel = new CheckinDailyModel();
        $checkinDailyModel->where("status", 1);
        $checkinDailyModel->where("agent", $agent->code);
        $checkinDailyModel->where("user", $body->user);
        $checkinDailyModel->where("checkin", $body->checkin);
        $checkinDailyModel->where("date_format(date,'%Y%m')", date_format(date_create($body->date), "Ym"));
        $checkinDaily = $checkinDailyModel->select("group_concat(progress) as progress")->first();

        $progressModel = new ProgressModel();
        $progressModel->where("status", 1);
        $progressModel->where("agent", $agent->code);
        if ($checkinDaily->progress) $progressModel->whereNotIn("id", explode(",", $checkinDaily->progress));
        $progress = $progressModel->orderBy("index")->first();
        if (!$progress) return $this->sendData(null, "Invalide Progress !", false);

        $body->progress = $progress->id;
        $body->title = $progress->title;
        $body->type = $progress->type;
        $body->value = $progress->value;
        if (!$progress->value) $body->date_claim = date("Y-m-d H:i:s");
        $body->date_use = date("Y-m-d H:i:s");

        $body->agent = $agent->code;
        $body->add_date = date('Y-m-d H:i:s');
        $id = $checkinDailyModel->insert($body);
        $checkinDaily = $checkinDailyModel->find($id);
        return $this->sendData($checkinDaily);
    }
    public function info()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $checkinDailyModel = new CheckinDailyModel();
        $checkinDailyModel->where("id", $body->id);
        $checkinDailyModel->where("user", $body->user);
        $checkinDailyModel->where("checkin", $body->checkin);
        $checkinDaily = $checkinDailyModel->where("agent", $agent->code)->first();

        return $this->sendData($checkinDaily);
    }
    public function usable()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $progressModel = new ProgressModel();
        $progressModel->where("status", 1);
        $progressModel->where("agent", $agent->code);
        $progressModel->where("checkin", $body->checkin);
        $progresses = $progressModel->findAll();
        if (!$progresses) return $this->sendData($progresses, "Invalide Progress !", false);

        $checkinDailyModel = new CheckinDailyModel();
        $checkinDailyModel->where("status", 1);
        $checkinDailyModel->where("user", $body->user);
        $checkinDailyModel->where("checkin", $body->checkin);
        $checkinDailyModel->where("date", $body->date);
        $checkinDaily = $checkinDailyModel->where("agent", $agent->code)->first();
        if ($checkinDaily) return $this->sendData(false);

        $checkinDailyModel->where("status", 1);
        $checkinDailyModel->where("user", $body->user);
        $checkinDailyModel->where("checkin", $body->checkin);
        $checkinDaileis = $checkinDailyModel->where("agent", $agent->code)->findAll();
        if (count($checkinDaileis) >= count($progresses)) return $this->sendData(false);

        return $this->sendData(true);
    }
    public function claim()
    {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $checkinDailyModel = new CheckinDailyModel();
        $checkinDailyModel
            ->where("id", $body->id)
            ->where("agent", $agent->code)
            ->where("user", $body->user)
            ->where("checkin", $body->checkin)
            ->where("status", 1)
            ->where("ifnull(date_use,'') != ''")
            ->where("ifnull(date_claim,'') = ''");
        $checkinDaily = $checkinDailyModel->first();
        if (!$checkinDaily) return $this->sendData(null, "Can't claim !", false);

        $body->date_claim = date('Y-m-d H:i:s');
        $body->edit_date = date('Y-m-d H:i:s');
        $checkinDailyModel->update($body->id, $body);
        $checkinDaily = $checkinDailyModel->find($body->id);
        return $this->sendData($checkinDaily);
    }
}

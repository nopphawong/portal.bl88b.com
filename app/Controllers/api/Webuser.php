<?php

namespace App\Controllers\api;

use App\Models\AgentModel;
use App\Models\WebuserModel;

class Webuser extends BaseController {
    public function register() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $WebuserModel = new WebuserModel();

        $WebuserModel->where("agent", $agent->code);
        $WebuserModel->where("tel", $body->tel);
        $WebuserModel->where("status", 1);
        $Webuser = $WebuserModel->first();
        if ($Webuser) return $this->sendError("เบอร์โทร ถูกใช้งานแล้ว !");

        $WebuserModel->where("status", 1);
        $WebuserModel->where("ifnull(date_use, '') = ''");
        $Webuser = $WebuserModel->orderBy("add_date")->first();
        if (!$Webuser) return $this->sendError("ไม่พบ Web User ที่ใช้งานได้ !");

        $Webuser->tel = $body->tel;
        $Webuser->agent = $agent->code;
        $Webuser->date_use = date("Y-m-d H:i:s");
        $Webuser->edit_date = date("Y-m-d H:i:s");
        $Webuser->edit_by = "API";

        $WebuserModel->save($Webuser);

        return $this->sendData([
            "web_username" => $Webuser->web_username, 
            "web_password" => $Webuser->web_password,
            "web_agent" => $Webuser->web_agent,
        ]);
    }
}

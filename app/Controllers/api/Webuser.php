<?php

namespace App\Controllers\api;

use App\Controllers\RestController;
use App\Models\AgentModel;
use App\Models\ChannelModel;
use App\Models\WebuserModel;

class Webuser extends RestController {
    public function register() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $Chanel = (object)["ref" => null, "name" => null];
        if (isset($body->ref) && !empty($body->ref)) {
            $ChannelModel = new ChannelModel();
            $ch = $ChannelModel->where("agent", $agent->code)->where("status", 1)->where("ref", $body->ref)->first();
            if ($ch) {
                $Chanel->ref = $ch->ref;
                $Chanel->name = $ch->name;
            }
        }

        $WebuserModel = new WebuserModel();
        $WebuserModel->where("agent", $agent->code);
        $WebuserModel->where("tel", $body->tel);
        $WebuserModel->where("status", 1);
        $Webuser = $WebuserModel->first();
        if ($Webuser) return $this->sendError("เบอร์โทร ถูกใช้งานแล้ว !");

        $WebuserModel->where("status", 1);
        $WebuserModel->where("agent", $agent->code);
        $WebuserModel->where("ifnull(date_use, '') = ''");
        $Webuser = $WebuserModel->orderBy("add_date")->first();
        if (!$Webuser) return $this->sendError("ไม่พบ Web User ที่ใช้งานได้ !");

        $Webuser->tel = $body->tel;
        $Webuser->date_use = date("Y-m-d H:i:s");
        $Webuser->edit_date = date("Y-m-d H:i:s");
        $Webuser->edit_by = "API";

        $success = $WebuserModel->save($Webuser);
        if (!$success) return $this->sendError("ผูก Web User ไม่สำเร็จ !");

        $body->web_username = $Webuser->web_username;
        log_message("alert", "WEBUSER-LINK :: " . json_encode($body));

        return $this->sendData([
            "web_username" => $Webuser->web_username,
            "web_password" => $Webuser->web_password,
            "web_agent" => $Webuser->web_agent,
            "chanel_ref" => $Chanel->ref,
            "chanel_name" => $Chanel->name,
        ]);
    }
    public function unlink() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $WebuserModel = new WebuserModel();
        $WebuserModel->where("agent", $agent->code);
        $WebuserModel->where("web_username", $body->web_username);
        $Webuser = $WebuserModel->first();
        if (!$Webuser) return $this->sendError("Web user ไม่ถูกต้อง !");
        if ($Webuser->tel != $body->tel) return $this->sendError("หมายเลขโทรศัพท์ ไม่ถูกต้อง !");
        $Webuser->tel = null;
        $Webuser->date_use = null;
        $Webuser->edit_date = date("Y-m-d H:i:s");
        $Webuser->edit_by = "API";
        $WebuserModel->save($Webuser);

        log_message("alert", "WEBUSER-UNLINK :: " . json_encode($body));

        return $this->sendData();
    }
    public function checkup() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $WebuserModel = new WebuserModel();
        $webuser = $WebuserModel->where("status", 1)->where("agent", $agent->code)->where("web_username", $body->webuser)->first();
        if (!$webuser) {
            $webuser = (object)[
                "web_username" => $body->webuser,
                "web_password" => $body->webpass,
                "web_agent" => substr($body->webuser, 0, 7),
                "agent" => $agent->code,
                "tel" => $body->tel,
                "date_use" => date("Y-m-d H:i:s"),
                "status" => 1,
                "add_date" => date("Y-m-d H:i:s"),
                "add_by" => "auto_api",
            ];
            $WebuserModel->save($webuser);
            return $this->sendData(false);
        }
        return $this->sendData(true);
    }
}

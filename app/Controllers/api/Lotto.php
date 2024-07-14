<?php

namespace App\Controllers\api;

use App\Controllers\RestController;
use App\Models\AgentModel;
use App\Models\LottoModel;
use App\Models\LottoTypeModel;
use App\Models\NumberMasterModel;
use App\Models\NumberModel;
use App\Models\UserPointModel;
use App\Models\WebuserModel;

class Lotto extends RestController {
    public function running_number_master($type_code) {
        $LottoTypeModel = new LottoTypeModel();
        $type = $LottoTypeModel->find($type_code);
        if (!$type) return $this->sendError("Type not found !");
        $NumberMasterModel = new NumberMasterModel();
        for ($i = $type->min; $i <= $type->max; $i++) {
            $NumberMasterModel->save([
                "type" => $type_code,
                "no" => str_pad($i, $type->length, "0", STR_PAD_LEFT),
                "status" => 1,
                "add_date" => date("Y-m-d H:i:s"),
                "add_by" => "admin_imi",
            ]);
        }
        $numbers = $NumberMasterModel->where("type", $type_code)->findAll();
        return $this->sendData($numbers);
    }
    
    public function list() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $db = db_connect();
        $lottoes = $db->query(
            "select id, type, period, start, expire, reward, price, bingo
                ,(select count(0) from tb_number_master where tb_number_master.`status` = 1 and tb_number_master.type = tb_lotto.type) as stock
                ,(select count(0) from tb_number where tb_number.`status` = 1 and tb_number.lotto = tb_lotto.id) as sold
            from tb_lotto where tb_lotto.`status` = 1 and tb_lotto.agent = :agent: and `start` <= :start: order by period desc",
            ["agent" => $agent->code, "start" => date("Y-m-d H:i:s")]
        )->getResultArray();
        $db->close();
        return $this->sendData($lottoes);
    }
    public function info() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $db = db_connect();
        $lotto = $db->query("select l.id, lt.`name` as type, l.period, l.`start`, l.expire, l.reward, l.price, l.bingo, up.`point`
        from tb_lotto l left join tb_lotto_type lt on lt.`code` = l.type and lt.`status` = 1
        left join tb_user_point up on up.`status` = 1 and up.`user` = :user:
        where l.`status` = 1 and l.id = :lotto:", ["lotto" => $body->lotto, "user" => $body->webuser])->getResult()[0];
        $db->close();
        if (!$lotto) return $this->sendError("ไม่พบข้อมูล !");

        return $this->sendData($lotto);
    }
    public function number_list() {
        $body = $this->getPost();
        $agentModel = new AgentModel();
        $agent = $agentModel->where("secret", $body->secret)->first();
        if (!$agent) return $this->sendData(null, "Invalide agent !", false);
        if ($agent->key != $body->key) return $this->sendData(null, "Invalide agent !", false);

        $db = db_connect();
        $numbers = $db->query(
            "select nm.`no`
                , if(ifnull(n.`user`, '') = '', 0, 1) as `sold`
                , if(ifnull(n.`user`, '') = :user:, 1, 0) as `owner`
            from tb_lotto l
            left join tb_number_master nm on nm.type = l.type and nm.`status` = 1
            left join tb_number n on n.lotto = l.id and n.`no` = nm.`no` and n.`status` = 1
            where l.`status` = 1 and l.agent = :agent: and l.id = :lotto:
            order by nm.`no`",
            ["agent" => $agent->code, "lotto" => $body->lotto, "user" => $body->webuser]
        )->getResultArray();
        $db->close();
        return $this->sendData($numbers);
    }
    public function number_buy() {
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
        }

        $UserPointModel = new UserPointModel();
        $user = $UserPointModel->where("status", 1)->where("agent", $agent->code)->where("user", $webuser->web_username)->first();
        if (!$user) return $this->sendError("ไม่มีสิทธิ์ใช้งาน !");
        if (empty($user->point)) return $this->sendError("แต้มไม่เพียงพอ !");

        $date = date("Y-m-d H:i:s");
        $LottoModel = new LottoModel();
        $lotto = $LottoModel->find($body->lotto);
        if (!$lotto) return $this->sendError("ไม่พบข้อมูล !");
        if ($lotto->agent != $agent->code) return $this->sendError("Invalide agent !");
        if (!$lotto->status) return $this->sendError("ไม่สามารถทำรายการได้ เนื่องจากแผงถูกยกเลิกไปแล้ว !");
        if ($lotto->start > $date) return $this->sendError("ไม่สามารถทำรายการได้ เนื่องจากยังไม่เปิดให้บริการ !");
        if ($lotto->expire < $date) return $this->sendError("ไม่สามารถทำรายการได้ เนื่องจากปิดบริการแล้ว !");
        if ($lotto->bingo) return $this->sendError("ไม่สามารถทำรายการได้ เนื่องจากออกผลรางวัลเสร็จสิ้นแล้ว !");
        if ($user->point - $lotto->price < 0) return $this->sendError("แต้มไม่เพียงพอ !");

        $NumberMasterModel = new NumberMasterModel();
        $number = $NumberMasterModel->where("status", 1)->where("type", $lotto->type)->where("no", $body->no)->first();
        if (!$number) return $this->sendError("หมายเลขไม่ถูกต้อง !");

        $NumberModel = new NumberModel();
        $number = $NumberModel->where("status", 1)->where("lotto", $lotto->id)->where("no", $body->no)->first();
        if ($number) return $this->sendError("หมายเลขถูกซื้อไปแล้ว !");

        $result = $NumberModel->insert([
            "lotto" => $lotto->id,
            "no" => $body->no,
            "sold_date" => $date,
            "user" => $body->webuser,
            "agent" => $agent->code,
            "status" => 1,
            "add_date" => $date,
            "add_by" => $body->webuser,
        ]);
        if ($result) {
            $user->point -= $lotto->price;
            $result = $UserPointModel->save($user);
        }
        return $this->sendData($result);
    }
}

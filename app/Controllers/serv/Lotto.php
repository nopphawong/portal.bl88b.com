<?php

namespace App\Controllers\serv;

use App\Controllers\RestController;
use App\Models\LottoModel;
use App\Models\LottoTypeModel;
use App\Models\NumberMasterModel;
use App\Models\NumberModel;
use App\Models\WebuserModel;

class Lotto extends RestController {
    public function list() {
        $db = db_connect();
        $lottoes = $db->query("select l.*
                ,lt.`name` as type_name
                ,ifnull(wu.tel, n.`user`) as winner
                ,(select count(0) from tb_number_master nmx where nmx.type = l.type and nmx.`status` = 1) as stock
                ,(select count(0) from tb_number nx where nx.lotto = l.id and nx.`status` = 1) as sold
        from tb_lotto l
        left join tb_number n on n.lotto = l.id and n.`no` = l.bingo and n.`status` = 1
        left join tb_webuser wu on wu.web_username = n.`user` and wu.`status` = 1
        left join tb_lotto_type lt on lt.`code` = l.type and l.`status` = 1
        where 1 = 1
        and l.agent = :agent:
        order by l.`status` desc, l.period desc", ["agent" => $this->session->agent->code])->getResultArray();
        $db->close();
        return $this->sendData($lottoes);
    }
    public function info() {
        $body = $this->getPost();
        $LottoModel = new LottoModel();
        $lotto = $LottoModel->find($body->id);
        if (!$lotto) return $this->sendError("Lotto not found !");
        return $this->sendData($lotto);
    }
    public function save() {
        $body = $this->getPost();
        $LottoModel = new LottoModel();
        if ($body->id) {
            $body->edit_date = date("Y-m-d H:i:s");
            $body->edit_by = $this->session->username;
        } else {
            unset($body->id);
            $body->agent = $this->session->agent->code;
            $body->status = 1;
            $body->add_date = date("Y-m-d H:i:s");
            $body->add_by = $this->session->username;
        }
        $result = $LottoModel->save($body);
        return $this->sendData($result);
    }
    public function bingo_update() {
        $body = $this->getPost();
        $LottoModel = new LottoModel();
        $lotto = $LottoModel->find($body->id);
        if (!$lotto) return $this->sendError("Lotto not found !");

        if (!empty($body->bingo)) {
            $NumberMasterModel = new NumberMasterModel();
            $number = $NumberMasterModel->where("status", 1)->where("type", $lotto->type)->where("no", $body->bingo)->first();
            if (!$number) return $this->sendError("Number is Invalid !");
        }

        $LottoModel = new LottoModel();
        $body->edit_date = date("Y-m-d H:i:s");
        $body->edit_by = $this->session->username;
        $result = $LottoModel->save($body);
        return $this->sendData($result);
    }
    public function remove($id) {
        $LottoModel = new LottoModel();
        $lotto = $LottoModel->delete($id);
        return $this->sendData($lotto);
    }
    public function active($id, $status = 0) {
        $LottoModel = new LottoModel();
        $body = $this->getPost();
        $body->id = $id;
        $body->status = $status;
        $body->edit_date = date("Y-m-d H:i:s");
        $body->edit_by = $this->session->username;
        $lotto = $LottoModel->save($body);
        return $this->sendData($lotto);
    }

    public function type_list() {
        $LottoTypeModel = new LottoTypeModel();
        $types = $LottoTypeModel->where("status", 1)->findAll();
        return $this->sendData($types);
    }

    public function number_list() {
        $body = $this->getPost();
        $db = db_connect();
        $numbers = $db->query("select n.*
            ,ifnull(wu.tel, n.`user`) as buyer
            ,if(ifnull(l.bingo, '') = '', 0, 1) as ended
            ,if(l.bingo = n.`no`, 1, 0) as winner 
        from tb_number n
        inner join tb_lotto l on l.id = n.lotto
        left join tb_webuser wu on wu.web_username = n.`user` and wu.`status` = 1
        where l.id = :lotto:
        order by n.`status` desc, winner desc, n.`no`", ["lotto" => $body->id])->getResultArray();
        $db->close();
        return $this->sendData($numbers);
    }
    public function number_add() {
        $body = $this->getPost();

        $LottoModel = new LottoModel();
        $lotto = $LottoModel->find($body->id);
        if (!$lotto) return $this->sendError("Lotto not Found !");

        $WebuserModel = new WebuserModel();
        $user = $WebuserModel->where("tel", $body->user)->where("agent", $lotto->agent)->where("status", 1)->first();
        if (!$user) return $this->sendError("User not Found !");

        $NumberMasterModel = new NumberMasterModel();
        $number = $NumberMasterModel->where("status", 1)->where("type", $lotto->type)->where("no", $body->no)->first();
        if (!$number) return $this->sendError("Number is Invalid !");

        $NumberModel = new NumberModel();
        $number = $NumberModel->where("status", 1)->where("lotto", $lotto->id)->where("no", $body->no)->first();
        if ($number) return $this->sendError("Number is Soldout !");

        $date = date("Y-m-d H:i:s");
        $result = $NumberModel->insert([
            "lotto" => $lotto->id,
            "no" => $body->no,
            "sold_date" => $date,
            "user" => $user->web_username,
            "agent" => $lotto->agent,
            "status" => 1,
            "add_date" => $date,
            "add_by" => $this->session->username,
        ]);
        return $this->sendData($result);
    }
    public function number_remove($id) {
        $NumberModel = new NumberModel();
        $number = $NumberModel->delete($id);
        return $this->sendData($number);
    }
    public function number_active($id, $status = 0) {
        $NumberModel = new NumberModel();
        $body = $this->getPost();
        $body->id = $id;
        $body->status = $status;
        $body->edit_date = date("Y-m-d H:i:s");
        $body->edit_by = $this->session->username;
        $number = $NumberModel->save($body);
        return $this->sendData($number);
    }
}

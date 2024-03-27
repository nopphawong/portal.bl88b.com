<?php

namespace App\Controllers\serv;

use App\Models\WebuserModel;

class Webuser extends BaseController {
    public function list() {
        $db = db_connect();
        $sql = "select 
            u.web_username
            ,u.web_password
            ,u.agent
            ,a.`name` as agent_name
            ,u.tel
            ,u.date_use
            ,u.status
        from tb_webuser u
        left join tb_agent a on a.`code` = u.agent
        where 1=1
        order by u.status desc, u.date_use, u.add_date desc";
        $Webusers = $db->query($sql)->getResult();
        return $this->sendData($Webusers);
    }
    public function add() {
        $body = $this->getPost();
        if (empty($body)) return $this->sendData(null, "Empty !", false);
        if (!isset($body->username) || empty($body->username)) return $this->sendData(null, "Username must be Empty !", false);
        if (!isset($body->password) || empty($body->password)) return $this->sendData(null, "Password must be Empty !", false);

        $WebuserModel = new WebuserModel();
        $user = (object)[
            "web_username" => $body->username,
            "web_password" => $body->password,
            "status" => 1,
            "add_date" => date("Y-m-d H:i:s"),
            "add_by" => $this->session->username,
        ];
        $WebuserModel->insert($user);
        return $this->sendData($user);
    }
    public function toggle($username, $status) {
        $WebuserModel = new WebuserModel();
        $user = (object)[
            "web_username" => $username,
            "status" => $status,
            "edit_date" => date("Y-m-d H:i:s"),
            "edit_by" => $this->session->username,
        ];
        $WebuserModel->save($user);
        return $this->sendData();
    }
    public function remove($username) {
        $WebuserModel = new WebuserModel();
        $WebuserModel->delete($username);
        return $this->sendData();
    }
}

<?php

namespace App\Controllers\serv;

use App\Models\WebuserModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Webuser extends BaseController {
    private $WebuserModel;
    public function list() {
        $db = db_connect();
        $sql = "select 
            u.web_username
            ,u.web_password
            ,u.web_agent
            ,u.agent
            ,a.`name` as agent_name
            ,u.tel
            ,u.date_use
            ,u.status
        from tb_webuser u
        left join tb_agent a on a.`code` = u.agent
        where 1=1
        and u.agent = :agent:
        order by u.status desc, u.date_use, u.add_date desc";
        $Webusers = $db->query($sql, ["agent" => $this->session->agent->code])->getResult();
        $db->close();
        return $this->sendData($Webusers);
    }
    public function add() {
        $body = $this->getPost();
        if (empty($body)) return $this->sendData(null, "Empty !", false);
        if (!isset($body->username) || empty($body->username)) return $this->sendData(null, "Username must be Empty !", false);
        if (!isset($body->password) || empty($body->password)) return $this->sendData(null, "Password must be Empty !", false);
        if (!isset($body->agent) || empty($body->agent)) return $this->sendData(null, "Agent must be Empty !", false);

        $this->save($body->username, $body->password, $body->agent, $this->session->username, $this->session->agent->code);
        return $this->sendData($body);
    }
    public function import() {
        $excel = $this->request->getFile("excel");
        $spreadsheet = IOFactory::load((string) $excel);
        $result = [];
        for ($i = 0; $i < $spreadsheet->getSheetCount(); $i++) {
            $sheet = $spreadsheet->getSheet($i);
            $dataArray = $sheet->toArray();
            foreach ($dataArray as $idx => $data) {
                if ($idx == 0) continue;
                if (!isset($data[0]) || empty($data[0])) continue;
                if (!isset($data[1]) || empty($data[1])) continue;
                if (!isset($data[2]) || empty($data[2])) continue;
                $ok = $this->save($data[0], $data[1], $data[2], $this->session->username, $this->session->agent->code);
                if ($ok) $result[] = $data;
            }
        }
        return $this->sendData($result);
    }
    protected function save($username, $password, $agent, $add_by, $agen_code) {
        if (empty($this->WebuserModel)) $this->WebuserModel = new WebuserModel();
        $user = $this->WebuserModel->find($username);
        if ($user) return false;
        $user = (object)[
            "web_username" => $username,
            "web_password" => $password,
            "web_agent" => $agent,
            "agent" => $agen_code,
            "status" => 1,
            "add_date" => date("Y-m-d H:i:s"),
            "add_by" => $add_by,
        ];
        return $this->WebuserModel->insert($user);
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

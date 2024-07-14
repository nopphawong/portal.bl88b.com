<?php

namespace App\Controllers\serv;

use App\Controllers\RestController;
use App\Libraries\Portal;
use App\Models\UserPointModel;
use App\Models\WebuserModel;

class User extends RestController {
    public function list($role = null) {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        if ($role) $body->role = $role;
        $body->agent = $this->session->agent->code;
        $users = $portal->user_list($body);
        if (!$users->status) return $this->sendData(null, $users->message, false);
        return $this->sendData($users->data);
    }

    public function add($role = null) {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        if ($role) $body->role = $role;
        $body->username = $this->session->agent->code . $body->username;
        $body->agent = $this->session->agent->code;
        $body->add_by = $this->session->username;
        $user = $portal->user_add($body);
        if (!$user->status) return $this->sendData(null, $user->message, false);
        return $this->sendData($user->data);
    }

    public function info() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $user = $portal->user_info($body);
        if (!$user->status) return $this->sendData(null, $user->message, false);
        return $this->sendData($user->data);
    }

    public function info_update() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $user = $portal->user_info_update($body);
        if (!$user->status) return $this->sendData(null, $user->message, false);
        return $this->sendData($user->data);
    }

    public function status_inactive() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $user = $portal->user_inactive($body);
        if (!$user->status) return $this->sendData(null, $user->message, false);
        return $this->sendData($user->data);
    }

    public function status_active() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $user = $portal->user_active($body);
        if (!$user->status) return $this->sendData(null, $user->message, false);
        return $this->sendData($user->data);
    }

    public function record_delete() {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $user = $portal->user_delete($body);
        if (!$user->status) return $this->sendData(null, $user->message, false);
        return $this->sendData($user->data);
    }

    public function point_list() {
        $db = db_connect();
        $users = $db->query("select up.*
            ,wu.tel
        from tb_user_point up
        inner join tb_webuser wu on wu.web_username = up.`user` and wu.`status` = 1
        where 1 = 1
        and up.agent = :agent:
        order by up.`status` desc, ifnull(up.edit_date, up.add_date) desc", ["agent" => $this->session->agent->code])->getResultArray();
        $db->close();
        return $this->sendData($users);
    }
    public function point_save() {
        $body = $this->getPost();

        $WebuserModel = new WebuserModel();
        $webuser = $WebuserModel->where("agent", $this->session->agent->code)->where("tel", $body->tel)->where("status", 1)->first();
        if (!$webuser) return $this->sendError("Tel not found !");

        $UserPointModel = new UserPointModel();
        $point = $UserPointModel->where("agent", $webuser->agent)->where("user", $webuser->web_username)->where("status", 1)->first();
        if (!$point) {
            $result = $UserPointModel->insert([
                "agent" => $webuser->agent,
                "user" => $webuser->web_username,
                "point" => $body->point ? $body->point : 0,
                "status" => 1,
                "add_date" => date("Y-m-d H:i:s"),
                "add_by" => $this->session->username,
            ]);
        } else {
            $result = $UserPointModel->update($point->id, [
                "point" => $body->point ? $body->point : 0,
                "edit_date" => date("Y-m-d H:i:s"),
                "edit_by" => $this->session->username
            ]);
        }
        return $this->sendData($result);
    }
    public function point_remove($id) {
        $UserPointModel = new UserPointModel();
        $point = $UserPointModel->delete($id);
        return $this->sendData($point);
    }
    public function point_active($id, $status = 0) {
        $UserPointModel = new UserPointModel();
        $body = $this->getPost();
        $body->id = $id;
        $body->status = $status;
        $body->edit_date = date("Y-m-d H:i:s");
        $body->edit_by = $this->session->username;
        $point = $UserPointModel->save($body);
        return $this->sendData($point);
    }
}

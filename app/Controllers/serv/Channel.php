<?php

namespace App\Controllers\serv;

use App\Controllers\RestController;
use App\Models\AgentModel;
use App\Models\ChannelModel;

class Channel extends RestController {
    public function list() {
        $AgentModel = new AgentModel();
        $agent = $AgentModel->where("code", $this->session->agent->code)->first();
        $ChannelModel = new ChannelModel();
        $channels = $ChannelModel->select("*, concat('{$agent->url}register?ref=', ref) as link")
            ->where("agent", $this->session->agent->code)->findAll();
        return $this->sendData($channels);
    }
    public function info() {
        $body = $this->getPost();
        $ChannelModel = new ChannelModel();
        $channel = $ChannelModel->find($body->id);
        return $this->sendData($channel);
    }
    public function save() {
        $body = $this->getPost();
        $ChannelModel = new ChannelModel();
        if ($body->id) {
            $body->edit_date = date("Y-m-d H:i:s");
            $body->edit_by = $this->session->username;
        } else {
            unset($body->id);
            $body->status = 1;
            $body->ref = base64_encode(uniqid());
            $body->agent = $this->session->agent->code;
            $body->add_date = date("Y-m-d H:i:s");
            $body->add_by = $this->session->username;
        }
        $result = $ChannelModel->save($body);
        return $this->sendData($result);
    }
    public function remove() {
        $body = $this->getPost();
        $ChannelModel = new ChannelModel();
        $channel = $ChannelModel->delete($body->id);
        return $this->sendData($channel);
    }
    public function active($status = 0) {
        $body = $this->getPost();
        $ChannelModel = new ChannelModel();
        $body->status = $status;
        $body->edit_date = date("Y-m-d H:i:s");
        $body->edit_by = $this->session->username;
        $channel = $ChannelModel->save($body);
        return $this->sendData($channel);
    }
}

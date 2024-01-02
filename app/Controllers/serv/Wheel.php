<?php

namespace App\Controllers\serv;

use App\Libraries\Portal;

class Wheel extends BaseController
{
    public function list()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $wheels = $portal->wheel_list($body);
        if (!$wheels->status) return $this->sendData(null, $wheels->message, false);
        return $this->sendData($wheels->data);
    }

    public function info()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $wheel = $portal->wheel_info($body);
        if (!$wheel->status) return $this->sendData(null, $wheel->message, false);
        return $this->sendData($wheel->data);
    }
    public function first()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $wheel = $portal->wheel_first($body);
        if ($wheel->status) return $this->sendData($wheel->data);

        $body->agent = $this->session->agent->code;
        $wheel = $portal->wheel_add($body);
        if (!$wheel->status) return $this->sendData(null, $wheel->message, false);
        return $this->sendData($wheel->data);
    }

    public function info_update()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $wheel = $portal->wheel_info_update($body);
        if (!$wheel->status) return $this->sendData(null, $wheel->message, false);
        return $this->sendData($wheel->data);
    }
}

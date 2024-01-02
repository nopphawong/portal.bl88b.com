<?php

namespace App\Controllers\serv;

use App\Libraries\Portal;

class Checkin extends BaseController
{
    public function list()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $checkins = $portal->checkin_list($body);
        if (!$checkins->status) return $this->sendData(null, $checkins->message, false);
        return $this->sendData($checkins->data);
    }

    public function info()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $checkin = $portal->checkin_info($body);
        if (!$checkin->status) return $this->sendData(null, $checkin->message, false);
        return $this->sendData($checkin->data);
    }
    public function first()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $checkin = $portal->checkin_first($body);
        if ($checkin->status) return $this->sendData($checkin->data);

        $body->deposit_rule = 100;
        $body->agent = $this->session->agent->code;
        $checkin = $portal->checkin_add($body);
        if (!$checkin->status) return $this->sendData(null, $checkin->message, false);
        return $this->sendData($checkin->data);
    }

    public function info_update()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $checkin = $portal->checkin_info_update($body);
        if (!$checkin->status) return $this->sendData(null, $checkin->message, false);
        return $this->sendData($checkin->data);
    }
}

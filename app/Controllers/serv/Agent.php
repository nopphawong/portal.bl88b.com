<?php

namespace App\Controllers\serv;

use App\Libraries\Apiv1;

class Agent extends BaseController
{
    public function info()
    {
        $api = new Apiv1();
        $api->set_secret($this->session->get("secret"));
        $agent = $api->agent_info();
        if (!$agent->status) return $this->response(null, $agent->message, false);
        return $this->response($agent->data, "Successful !");
    }

    public function info_update()
    {
        $body = $this->getPost();
        $body->edit_by = $this->session->get("username");
        $api = new Apiv1();
        $api->set_secret($this->session->get("secret"));
        $agent = $api->agent_info_update($body);
        if (!$agent->status) return $this->response(null, $agent->message, false);
        return $this->response($agent->data, "Update successful !");
    }
}

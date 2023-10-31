<?php

namespace App\Controllers\serv;

use App\Libraries\Apiv1;
use App\Libraries\Base64fileUploads;

class Agent extends BaseController
{
    public function info()
    {
        $body = $this->getPost();
        $api = new Apiv1($this->session->agent);

        $body->agent = $this->session->agent->code;
        $agent = $api->agent_info($body);
        if (!$agent->status) return $this->response(null, $agent->message, false);
        return $this->response($agent->data);
    }

    public function info_update()
    {
        $body = $this->getPost();
        $api = new Apiv1($this->session->agent);
        $file = new Base64fileUploads();

        if (!empty($body->logo_upload)) {
            $this->unlink_image($body->logo);
            $logo = $file->du_uploads($body->logo_upload, "images", "{$this->session->agent->code}logo_" . uniqid());
            $this->resize_image($logo->file_path, 320, 100);
            $body->logo = site_url($logo->file_path);
        }

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $agent = $api->agent_info_update($body);
        if (!$agent->status) return $this->response(null, $agent->message, false);
        return $this->response($agent->data);
    }

    public function list()
    {
        $body = $this->getPost();
        $api = new Apiv1();

        $agents = $api->agent_list($body);
        if (!$agents->status) return $this->response(null, $agents->message, false);
        return $this->response($agents->data);
    }

    public function add()
    {
        $body = $this->getPost();
        $api = new Apiv1($body);

        $body->add_by = $this->session->username;
        $agent = $api->agent_add($body);
        if (!$agent->status) return $this->response(null, $agent->message, false);
        return $this->response($agent->data);
    }

    public function status_inactive()
    {
        $body = $this->getPost();
        $api = new Apiv1($body);

        $body->edit_by = $this->session->username;
        $agent = $api->agent_inactive($body);
        if (!$agent->status) return $this->response(null, $agent->message, false);
        return $this->response($agent->data);
    }

    public function status_active()
    {
        $body = $this->getPost();
        $api = new Apiv1($body);

        $body->edit_by = $this->session->username;
        $agent = $api->agent_active($body);
        if (!$agent->status) return $this->response(null, $agent->message, false);
        return $this->response($agent->data);
    }
}

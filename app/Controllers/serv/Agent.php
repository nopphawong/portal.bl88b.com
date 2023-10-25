<?php

namespace App\Controllers\serv;

use App\Libraries\Apiv1;
use App\Libraries\Base64fileUploads;

class Agent extends BaseController
{
    public function info()
    {
        $body = $this->getPost();
        $api = new Apiv1($this->session->agent->secret);
        $body->agent = $this->session->agent->key;
        $agent = $api->agent_info($body);
        if (!$agent->status) return $this->response(null, $agent->message, false);
        return $this->response($agent->data);
    }

    public function info_update()
    {
        $api = new Apiv1($this->session->agent->secret);
        $body = $this->getPost();
        $file = new Base64fileUploads();

        if (!empty($body->logo_upload)) {
            $this->unlink_image($body->logo);
            $logo = $file->du_uploads($body->logo_upload, "images", "{$this->session->agent->key}logo_" . uniqid());
            $this->resize_image($logo->file_path, 320, 100);
            $body->logo = site_url($logo->file_path);
        }

        $body->agent = $this->session->agent->key;
        $body->edit_by = $this->session->username;
        $agent = $api->agent_info_update($body);
        if (!$agent->status) return $this->response(null, $agent->message, false);
        return $this->response($agent->data);
    }
}

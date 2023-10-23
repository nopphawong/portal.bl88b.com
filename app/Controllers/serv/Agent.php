<?php

namespace App\Controllers\serv;

use App\Libraries\Apiv1;
use App\Libraries\Base64fileUploads;

class Agent extends BaseController
{
    public function info()
    {
        $api = new Apiv1($this->session->agent->secret);
        $agent = $api->agent_info();
        if (!$agent->status) return $this->response(null, $agent->message, false);
        return $this->response($agent->data, "Successful !");
    }

    public function info_update()
    {
        $api = new Apiv1($this->session->agent->secret);
        $body = $this->getPost();
        $file = new Base64fileUploads();

        if (!empty($body->logo_new)) {
            $logo = $file->du_uploads($body->logo_new, "images", "{$this->session->agent->key}logo");

            $image = \Config\Services::image();
            $image->withFile($logo->file_path)->resize(250, 250, true, 'auto')->save($logo->file_path);

            $body->logo = site_url($logo->file_path);
        }

        $body->edit_by = $this->session->username;
        $agent = $api->agent_info_update($body);
        if (!$agent->status) return $this->response(null, $agent->message, false);
        return $this->response($agent->data, "Update successful !");
    }
}

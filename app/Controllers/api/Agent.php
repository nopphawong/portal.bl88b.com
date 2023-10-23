<?php

namespace App\Controllers\api;

use App\Libraries\Base64fileUploads;
use App\Models\AgentModel;

class Agent extends BaseController
{
    protected $agent;
    protected $agentModel;
    protected $body;

    public function __construct()
    {
        $this->agentModel = new AgentModel();
    }

    public function execute_path($s1, $s2, $s3)
    {
        $method = implode("_", array_filter([$s1, $s2, $s3]));
        if (!method_exists($this, $method)) return $this->response(null, "Function not found !", false);

        $this->body = $this->getPost();
        $this->agent = $this->agentModel->where("secret", $this->body->secret)->first();
        if (!$this->agent) return $this->response(null, "Invalide agent !", false);
        return $this->$method();
    }

    protected function info()
    {
        return $this->response($this->agent, "Successful !");
    }

    protected function info_update()
    {
        $file = new Base64fileUploads();
        if (!empty($this->body->logo_new)) {
            $logo = $file->du_uploads($this->body->logo_new, "images", "{$this->agent->code}logo");
            $this->body->logo = site_url($logo->file_path);

            $image = \Config\Services::image();
            $image->withFile($logo->file_path)->resize(250, 250, true, 'auto')->save($logo->file_path);
        }
        $this->body->id = $this->agent->id;
        $this->body->edit_date = date("Y-m-d H:i:s");
        $this->agentModel->save($this->body);
        return $this->response(null, "Update successful !");
    }

    public function add()
    {
        $body = $this->getPost();
        return $this->response($body, "Add successful !");
    }
}

<?php

namespace App\Controllers\api;

use App\Libraries\Base64fileUploads;
use App\Models\AgentModel;

class Web extends BaseController
{
    protected $agentModel;
    protected $agent;
    protected $body;

    public function execute_path($s1, $s2, $s3)
    {
        $method = implode("_", array_filter([$s1, $s2, $s3]));
        if (!method_exists($this, $method)) return $this->response(null, "Function not found !", false);

        $this->body = $this->getPost();
        $this->agentModel = new AgentModel();
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
        if (!empty($this->body->logo_new)) {
            $file = new Base64fileUploads();
            $upload = $file->du_uploads("images", $this->body->logo_new);
            $this->body->logo = base_url($upload->file_path);
        }
        $this->body->id = $this->agent->id;
        $this->body->edit_date = date("Y-m-d H:i:s");
        $this->agentModel->save($this->body);
        return $this->response(null, "Update successful !");
    }
}

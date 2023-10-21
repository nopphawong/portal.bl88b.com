<?php

namespace App\Controllers\api;

use App\Libraries\Base64fileUploads;
use App\Models\AgentModel;

class Web extends BaseController
{
    protected $agentModel;
    protected $agent;

    public function execute_path($secret, $s1, $s2)
    {
        $method = implode("_", array_filter([$s1, $s2]));
        if (!method_exists($this, $method)) return $this->response(null, "Function not found !", false);

        $this->agentModel = new AgentModel();
        $this->agent = $this->agentModel->where("secret", $secret)->first();
        if (!$this->agent) return $this->response(null, "Invalide agent !", false);
        return $this->$method();
    }

    protected function info()
    {
        return $this->response($this->agent, "Successful !");
    }

    protected function info_update()
    {
        $body = $this->getPost();
        if (!empty($body->logo_new)) {
            $file = new Base64fileUploads();
            $upload = $file->du_uploads("images", $body->logo_new);
            $body->logo = base_url($upload->file_path);
        }
        $body->id = $this->agent->id;
        $body->edit_date = date("Y-m-d H:i:s");
        $this->agentModel->save($body);
        return $this->response(null, "Update successful !");
    }
}

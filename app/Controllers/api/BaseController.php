<?php

namespace App\Controllers\api;

use CodeIgniter\RESTful\ResourceController;

class BaseController extends ResourceController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
    }
    protected function response($data = null, $message = "Successful !", $status = true)
    {
        $data = array("status" => $status, "message" => $message, "data" => $data,);
        return $this->respond($data);
    }
    protected function getPost($index = false)
    {
        if ($this->request->is('json')) $body = !$index ? $this->request->getVar() : $this->request->getVar($index);
        else $body =  !$index ? $this->request->getPost() : $this->request->getPost($index);
        return (object) $body;
    }
}

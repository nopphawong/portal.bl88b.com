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
    protected function response($data = null, $message = "ดำเนินการเสร็จสิ้น !", $status = true)
    {
        $data = array(
            "status" => $status,
            "message" => $message,
            "data" => $data,
        );
        return $this->respond($data);
    }
    protected function getPost($index = false)
    {
        if ($this->request->is('json')) return !$index ? $this->request->getVar() : $this->request->getVar($index);
        return !$index ? $this->request->getPost() : $this->request->getPost($index);
    }
    protected function str_censor($str)
    {
        $target = $str;
        $count = round(strlen($target) * 0.3);
        $output = substr_replace($target, str_repeat('*', $count), strlen($target) - round($count * 1.5), $count);
        return $output;
    }
}

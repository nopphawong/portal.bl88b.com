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

    protected function is_number($str)
    {
        return preg_match("/^[0-9]{1,}$/", $str);
    }
    protected function validate_phone($tel)
    {
        return preg_match("/^[0-9]{3}[0-9]{3}[0-9]{4}$/", $tel);
    }
    protected function validate_username($username)
    {
        return preg_match("/^[A-Za-z0-9]{6,30}$/", $username);
    }
    protected function validate_password($password)
    {
        return $password && strlen($password);
        return preg_match('/^[\w\d_@\-]{6,20}$/', $password);
    }
    protected function clean($string, $tolower = true)
    {
        if ($tolower) $string = strtolower($string);
        $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9]/', '', $string); // Removes special chars.

        return  $string; // Replaces multiple hyphens with single one.
    }
}

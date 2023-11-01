<?php

namespace App\Controllers\serv;

use App\Libraries\Apiv1;

class User extends BaseController
{
    public function list($role = null)
    {
        $body = $this->getPost();
        $api = new Apiv1($this->session->agent);

        if ($role) $body->role = $role;
        $body->agent = $this->session->agent->code;
        $users = $api->user_list($body);
        if (!$users->status) return $this->response(null, $users->message, false);
        return $this->response($users->data);
    }

    public function add($role = null)
    {
        $body = $this->getPost();
        $api = new Apiv1($this->session->agent);

        if ($role) $body->role = $role;
        $body->username = $this->session->agent->code . $body->username;
        $body->agent = $this->session->agent->code;
        $body->add_by = $this->session->username;
        $user = $api->user_add($body);
        if (!$user->status) return $this->response(null, $user->message, false);
        return $this->response($user->data);
    }

    public function info()
    {
        $body = $this->getPost();
        $api = new Apiv1($this->session->agent);

        $body->agent = $this->session->agent->code;
        $user = $api->user_info($body);
        if (!$user->status) return $this->response(null, $user->message, false);
        return $this->response($user->data);
    }

    public function info_update()
    {
        $body = $this->getPost();
        $api = new Apiv1($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $user = $api->user_info_update($body);
        if (!$user->status) return $this->response(null, $user->message, false);
        return $this->response($user->data);
    }

    public function status_inactive()
    {
        $body = $this->getPost();
        $api = new Apiv1($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $user = $api->user_inactive($body);
        if (!$user->status) return $this->response(null, $user->message, false);
        return $this->response($user->data);
    }

    public function status_active()
    {
        $body = $this->getPost();
        $api = new Apiv1($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $user = $api->user_active($body);
        if (!$user->status) return $this->response(null, $user->message, false);
        return $this->response($user->data);
    }

    public function record_delete()
    {
        $body = $this->getPost();
        $api = new Apiv1($this->session->agent);

        $body->agent = $this->session->agent->code;
        $user = $api->user_delete($body);
        if (!$user->status) return $this->response(null, $user->message, false);
        return $this->response($user->data);
    }
}

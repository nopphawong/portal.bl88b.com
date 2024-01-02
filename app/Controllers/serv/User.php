<?php

namespace App\Controllers\serv;

use App\Libraries\Portal;

class User extends BaseController
{
    public function list($role = null)
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        if ($role) $body->role = $role;
        $body->agent = $this->session->agent->code;
        $users = $portal->user_list($body);
        if (!$users->status) return $this->sendData(null, $users->message, false);
        return $this->sendData($users->data);
    }

    public function add($role = null)
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        if ($role) $body->role = $role;
        $body->username = $this->session->agent->code . $body->username;
        $body->agent = $this->session->agent->code;
        $body->add_by = $this->session->username;
        $user = $portal->user_add($body);
        if (!$user->status) return $this->sendData(null, $user->message, false);
        return $this->sendData($user->data);
    }

    public function info()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $user = $portal->user_info($body);
        if (!$user->status) return $this->sendData(null, $user->message, false);
        return $this->sendData($user->data);
    }

    public function info_update()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $user = $portal->user_info_update($body);
        if (!$user->status) return $this->sendData(null, $user->message, false);
        return $this->sendData($user->data);
    }

    public function status_inactive()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $user = $portal->user_inactive($body);
        if (!$user->status) return $this->sendData(null, $user->message, false);
        return $this->sendData($user->data);
    }

    public function status_active()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $body->edit_by = $this->session->username;
        $user = $portal->user_active($body);
        if (!$user->status) return $this->sendData(null, $user->message, false);
        return $this->sendData($user->data);
    }

    public function record_delete()
    {
        $body = $this->getPost();
        $portal = new Portal($this->session->agent);

        $body->agent = $this->session->agent->code;
        $user = $portal->user_delete($body);
        if (!$user->status) return $this->sendData(null, $user->message, false);
        return $this->sendData($user->data);
    }
}

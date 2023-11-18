<?php

namespace App\Controllers;

use App\Libraries\Portal;
use App\Libraries\Encrypter;

class Page extends BaseController
{
    public function forbidden()
    {
        return view("adminlte/pages/forbidden", $this->viewData);
    }
    public function index()
    {
        if (is_master(session()->role)) return redirect()->to(site_url("agent"));
        return redirect()->to(site_url("agent/info"));
    }

    public function detect($bin)
    {
        $ect = new Encrypter();
        $decoded = $ect->decode($bin);
        $session_data = $ect->plaintext_to_data($decoded);
        if (!$this->set_session($session_data)) return redirect()->to(site_url("login"));
        return redirect()->to(site_url("/"));
    }
    protected function set_session($session_data)
    {
        if (!$session_data) return false;
        $session_data = (object) $session_data;
        if (!isset($session_data->logged_in)) return false;
        if (!isset($session_data->username)) return false;
        if (!isset($session_data->role)) return false;
        // if (!isset($session_data->agent)) return false;
        // if (!isset($session_data->agent->key)) return false;
        // if (!isset($session_data->agent->secret)) return false;
        // if (!isset($session_data->agent->code)) return false;
        session()->set((array) $session_data);
        return true;
    }

    public function login()
    {
        return view("adminlte/pages/login", $this->viewData);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url("login"));
    }

    public function agent_info()
    {
        return view("adminlte/pages/agent_info", $this->viewData);
    }
    public function banner()
    {
        return view("adminlte/pages/banner", $this->viewData);
    }
    public function admin()
    {
        return view("adminlte/pages/admin", $this->viewData);
    }
    public function agent()
    {
        session()->remove("agent");
        return view("adminlte/pages/agent", $this->viewData);
    }
    public function agent_view($code, $key, $secret)
    {
        $portal = new Portal((object) array("key" => $key, "secret" => $secret,));
        $agent = $portal->agent_info(["code" => $code,]);
        if (!$agent) return redirect()->to(previous_url());
        $session_data = (object) session()->get();
        $session_data->agent = (object) array(
            "code" => $agent->data->code,
            "key" => $agent->data->key,
            "secret" => $agent->data->secret,
            "name" => $agent->data->name,
        );
        session()->set((array) $session_data);
        return redirect()->to(site_url("agent/info"));
    }
}

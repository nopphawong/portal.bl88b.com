<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function index()
    {
        return redirect()->to(site_url("agent/info"));
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
        // $this->use_datatable();
        return view("adminlte/pages/banner", $this->viewData);
    }
}

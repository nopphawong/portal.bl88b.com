<?php

namespace App\Controllers;

class Page extends BaseController
{
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
}

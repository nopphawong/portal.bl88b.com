<?php

namespace App\Controllers;

use App\Libraries\Portal;

class Page extends BaseController {
    public function index() {
        if (is_master(session()->role)) return redirect()->to(site_url("agent"));
        return redirect()->to(site_url("agent/info"));
    }
    public function agent_info() {
        return $this->setView("adminlte/pages/agent_info");
    }
    public function banner() {
        return $this->setView("adminlte/pages/banner");
    }
    public function admin() {
        return $this->setView("adminlte/pages/admin");
    }
    public function channel() {
        return $this->setView("adminlte/pages/channel");
    }
    public function wheel_info() {
        return $this->setView("adminlte/pages/wheel_info");
    }
    public function checkin_info() {
        return $this->setView("adminlte/pages/checkin_info");
    }
    public function agent() {
        session()->remove("agent");
        return $this->setView("adminlte/pages/agent");
    }
    public function webuser() {
        $this->usePrimevue();
        // $this->usePrimevueLib("datatable");
        // $this->usePrimevueLib("column");
        return $this->setView("adminlte/pages/webuser");
    }
    public function agent_view($code, $key, $secret) {
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

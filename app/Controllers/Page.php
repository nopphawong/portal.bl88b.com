<?php

namespace App\Controllers;

use App\Libraries\Portal;

class Page extends BaseController {
    public function index() {
        if (is_master(session()->role)) return redirect()->to(site_url("agent"));
        return redirect()->to(site_url("agent/info"));
    }
    public function agent_info() {
        return $this->renderView("adminlte/pages/agent_info");
    }
    public function banner() {
        return $this->renderView("adminlte/pages/banner");
    }
    public function admin() {
        return $this->renderView("adminlte/pages/admin");
    }
    public function channel() {
        return $this->renderView("adminlte/pages/channel");
    }
    public function lotto() {
        $this->usePrimevue();
        return $this->renderView("adminlte/pages/lotto");
    }
    public function user_point() {
        $this->usePrimevue();
        return $this->renderView("adminlte/pages/user_point");
    }
    public function wheel_info() {
        return $this->renderView("adminlte/pages/wheel_info");
    }
    public function checkin_info() {
        return $this->renderView("adminlte/pages/checkin_info");
    }
    public function agent() {
        session()->remove("agent");
        return $this->renderView("adminlte/pages/agent");
    }
    public function webuser() {
        $this->usePrimevue();
        // $this->usePrimevueLib("datatable");
        // $this->usePrimevueLib("column");
        return $this->renderView("adminlte/pages/webuser");
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

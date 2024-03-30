<?php

namespace App\Controllers;

use App\Libraries\Encrypter;

class Auth extends BaseController {
    public function forbidden() {
        return $this->setView("adminlte/pages/forbidden");
    }
    public function detect($bin) {
        $ect = new Encrypter();
        $decoded = $ect->decode($bin);
        $session_data = $ect->plaintext_to_data($decoded);
        if (!$this->set_session($session_data)) return redirect()->to(site_url("login"));
        return redirect()->to(site_url("/"));
    }
    protected function set_session($session_data) {
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
    public function login() {
        return $this->setView("adminlte/pages/login");
    }
    public function logout() {
        session()->destroy();
        return redirect()->to(site_url("login"));
    }
}

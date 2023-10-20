<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view("adminlte/pages/home", $this->viewData);
    }
}
